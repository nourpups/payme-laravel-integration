<?php

namespace App\Services\Payme;

use App\Contracts\PaymeContract;
use App\Enum\Payme\State;
use App\Enum\Order\State as OrderState;
use App\Exceptions\Payme\JsonException;
use App\Exceptions\Payme\TransactionException;
use App\Exceptions\Payme\OrderException;
use App\Exceptions\Payme\AmountException;
use App\Models\Order;
use App\Models\PaymeTransaction;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class Payme implements PaymeContract
{
    public function __construct(public array $parameters, public SuccesfulResponse $response)
    {
    }

    /**
     * public array $parameters
     * @throws \Throwable
     */
    public function CheckPerformTransaction(): JsonResponse
    {
        throw_if(
            !$this->hasParameter('amount', 'account'),
            JsonException::jsonRpcError()
        );

        $amount = $this->parameters['amount'];
        throw_if(
            !$this->isAmountValid($amount),
            AmountException::wrongAmount()
        );

        throw_if(
            $key = $this->parameters['account']['order_id'],
            OrderException::orderNotFound()::orderNotFound()
        );

        $order = Order::where(config('payme.identity'), $key)->first();
        throw_if(
            empty($order),
            OrderException::orderNotFound()
        );

        $items = [];
        foreach ($order->products as $product) {
            $items[] = [
                'title' => $product->name,
                'price' => $product->price,
                'count' => $product->pivot->count,
                'code' => $product->code, // ИКПУ
                'package_code' => $product->package_code,
                'vat_percent' => Product::VAT_PERCENT, // НДС
            ];
        }

        return $this->response->successCheckPerformTransaction($items);
    }

    /**
     * @throws \Throwable
     * @throws TransactionException
     */
    public function CreateTransaction(): JsonResponse
    {

        throw_if(
            !$this->hasParameter('id', 'time', 'amount', 'account'),
            JsonException::jsonRpcError()
        );

        $id = $this->parameters['id'];
        $time = $this->parameters['time'];
        $amount = $this->parameters['amount'];

        $account = $this->parameters['account'][config('payme.identity')];

        $order = Order::where(config('payme.identity'), $account)->exists();

        throw_if(
            !$order,
            OrderException::orderNotFound()
        );

        throw_if(
            !$this->isAmountValid($amount),
            AmountException::wrongAmount()
        );

        $transaction = PaymeTransaction::where('transaction', $id)->first();

        if ($transaction) {
            throw_if(
                $transaction->state != State::PENDING,
                TransactionException::cantPerformTransaction()
            );

            if ($transaction->isExpired()) {
                $transaction->update([
                    'state' => State::CANCELLED,
                    'reason' => 4
                ]);

                throw TransactionException::timeoutExpired();
            }

            return $this->response->successCreateTransaction(
                $transaction->state,
                $transaction->create_time,
                $transaction->id
            );

        }

        $transaction = PaymeTransaction::create([
            'transaction' => $id,
            'pay_time' => $time,
            'amount' => $amount,
            'state' => State::PENDING,
            'create_time' => time() * 1000,
            'order_id' => $account,
        ]);

        return $this->response->successCreateTransaction(
            $transaction->state,
            $transaction->create_time,
            $transaction->id
        );
    }

    /**
     * @throws \Throwable
     * @throws TransactionException
     */
    public function PerformTransaction(): JsonResponse
    {
        {
            throw_if(
                !$this->hasParameter('id'),
                JsonException::jsonRpcError()
            );
        }
        $id = $this->parameters['id'];

        $transaction = PaymeTransaction::where('transaction', $id)->first();
        throw_if(
            empty($transaction),
            TransactionException::transactionNotFound()
        );

        if ($transaction->state !== State::PENDING) {

            throw_if(
                $transaction->state !== State::DONE,
                TransactionException::cantPerformTransaction()
            );

            return $this->response->successPerformTransaction(
                $transaction->perform_time,
                $transaction->id,
                $transaction->state
            );
        }
        $order = Order::find($transaction->order_id);
        $order->update([
            'state' => OrderState::CONFIRMED
        ]);

        if ($transaction->isExpired()) {
            $transaction->update([
                'state' => State::CANCELLED,
                'reason' => 4
            ]);

            throw TransactionException::timeoutExpired();
        }

        $transaction->state = State::DONE;
        $transaction->perform_time = time() * 1000;
        $transaction->save();

        return $this->response->successPerformTransaction(
            $transaction->perform_time,
            $transaction->id,
            $transaction->state
        );
    }

    /**
     * @throws \Throwable
     */
    public function CancelTransaction(): JsonResponse
    {
        throw_if(
            !$this->hasParameter('id', 'reason'),
            JsonException::jsonRpcError()
        );

        $id = $this->parameters['id'];
        $reason = $this->parameters['reason'];

        $transaction = PaymeTransaction::where('transaction', $id)->first();

        throw_if(
            empty($transaction),
            TransactionException::transactionNotFound()
        );

        if ($transaction->state === State::PENDING) {
            $order = Order::find($transaction->order_id);
            $order->update([
               'state' => OrderState::CANCELED
            ]);

            $cancelTime = time() * 1000;
            $transaction->update([
                'state' => State::CANCELLED,
                'cancel_time' => $cancelTime,
                'reason' => $reason
            ]);

            return $this->response->successCancelTransaction(
                $transaction->state,
                $cancelTime,
                $transaction->id
            );
        }

        if ($transaction->state !== State::DONE) {
            return $this->response->successCancelTransaction(
                $transaction->state,
                $transaction->cancel_time,
                $transaction->id
            );
        }

        throw_if(
            !$transaction->allowCancel(),
            TransactionException::cantCancelTransaction()
        );
        $order = Order::find($transaction->order_id);
        $order->update([
            'state' => OrderState::CANCELED
        ]);

        $cancelTime = time() * 1000;

        $transaction->update([
            'state' => State::CANCELLED_AFTER_DONE,
            'cancel_time' => $cancelTime,
            'reason' => $reason
        ]);

        return $this->response->successCancelTransaction(
            $transaction->state,
            $cancelTime,
            $transaction->id
        );
    }

    /**
     * @throws \Throwable
     */
    public function CheckTransaction(): JsonResponse
    {
        throw_if(
            !$this->hasParameter('id'),
            JsonException::jsonRpcError()
        );

        $id = $this->parameters['id'];

        $transaction = PaymeTransaction::where('transaction', $id)->first();

        throw_if(
            empty($transaction),
            TransactionException::transactionNotFound()
        );

        return $this->response->successCheckTransaction(
            $transaction->state,
            $transaction->create_time,
            $transaction->perform_time,
            $transaction->cancel_time,
            $transaction->id,
            $transaction->reason
        );
    }

    private function isAmountValid($amount): bool
    {
        return config('payme.max_amount') > $amount && $amount > config('payme.min_amount');
    }

    private function hasParameter(string|array ...$params): bool
    {
        foreach ($params as $parameter) {
            if (empty($this->parameters[$parameter])) return false;
        }
        return true;
    }





}
