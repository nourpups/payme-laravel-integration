<?php

namespace App\Services\Payme;

use App\Http\Responses\PaymeResponse;
use Illuminate\Http\JsonResponse;

class SuccesfulResponse extends PaymeResponse
{
    public function successCreateTransaction($state, $createTime, $transaction): JsonResponse
    {
        return $this->success([
            'create_time' => $createTime,
            'perform_time' => 0,
            'cancel_time' => 0,
            'transaction' => (string)$transaction,
            'state' => $state,
            'reason' => null
        ]);
    }

    public function successCheckPerformTransaction($items): JsonResponse
    {


        return $this->success([
            'allow' => true,
            'detail' => [
                'receipt_type' => 0,
                'items' => $items
            ]
        ]);
    }

    public function successPerformTransaction($state, $performTime, $transaction): JsonResponse
    {
        return $this->success([
            'state' => $state,
            'perform_time' => $performTime,
            'transaction' => $transaction,
        ]);
    }

    public function successCheckTransaction($state, $createTime, $performTime, $cancelTime, $transaction, $reason): JsonResponse
    {
        return $this->success([
            'create_time' => $createTime ?? 0,
            'perform_time' => $performTime ?? 0,
            'cancel_time' => $cancelTime ?? 0,
            'transaction' => $transaction,
            'state' => $state,
            'reason' => $reason
        ]);
    }

    public function successCancelTransaction($state, $cancelTime, $transaction): JsonResponse
    {
        return $this->success([
            'state' => $state,
            'cancel_time' => $cancelTime,
            'transaction' => (string)$transaction
        ]);
    }
}
