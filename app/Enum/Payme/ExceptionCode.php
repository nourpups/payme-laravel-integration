<?php

namespace App\Enum\Payme;

enum ExceptionCode: int
{
    /**
     * Введены неверные данные аутентификации (login, password)
     */
    case AUTH_ERROR = -32504;

    /**
     * Неверная сумма.
     */
    case WRONG_AMOUNT = -31001;

    /**
     * Ошибки связанные с неверным пользовательским вводом "account".
     * Например: введенный логин не найден
     */
    case ORDER_NOT_FOUND = -31050;

    /**
     * Передан неправильный JSON-RPC объект.
     */
    case JSON_RPC_ERROR = -32600;

    /**
     * Транзакция не найдена.
     */
    case TRANSACTION_NOT_FOUND = -31003;

    /**
     * Запрашиваемый метод не найден.
     * Поле data не содержит запрашиваемый метод.
     */
    case METHOD_NOT_FOUND = -32601;

    /**
     * Неверный HTTP метод.
     */
    case INVALID_HTTP_METHOD = -32300;

    /**
     * Невозможно выполнить данную операцию.
     */
    case CANT_PERFORM_TRANSACTION = -31008;

    /**
     * Невозможно отменить транзакцию.
     * Товар или услуга предоставлена Потребителю в полном объеме.
     */
    case CANT_CANCEL_TRANSACTION = -31007;

    public function getMessage($code) {
        return match ($code) {
            self::INVALID_HTTP_METHOD => [
                "uz" => "So'rov xatoligi",
                "ru" => "Ошибка запроса",
                "en" => "Bad request"
            ],
            self::WRONG_AMOUNT => [
                "uz" => "Notog'ri summa.",
                "ru" => "Неверная сумма.",
                "en" => "Wrong amount.",
            ],
            self::ORDER_NOT_FOUND => [
                "uz" => "Buyurtma topilmadi",
                "ru" => "Заказ не найден",
                "en" => "Order not found",
            ],
            self::JSON_RPC_ERROR => [
                "uz" => "Noto'g'ri JSON-RPC obyekt yuborilgan.",
                "ru" => "Передан неправильный JSON-RPC объект.",
                "en" => "Handed the wrong JSON-RPC object."
            ],
            self::TRANSACTION_NOT_FOUND => [
                "uz" => "Transaksiya topilmadi",
                "ru" => "Трансакция не найдена",
                "en" => "Transaction not found"
            ],
            self::METHOD_NOT_FOUND => [
                "uz" => "Metod topilmadi",
                "ru" => "Запрашиваемый метод не найден.",
                "en" => "Method not found"
            ],
            self::CANT_PERFORM_TRANSACTION => [
                "uz" => "Ushbu operatsiyani bajarishni iloji yo'q",
                "ru" => "Невозможно выполнить данную операцию.",
                "en" => "Can't perform transaction",
            ],
            self::CANT_CANCEL_TRANSACTION => [
                "uz" => "Tranzaksiyani bekor qilib bo'lmaydi",
                "ru" => "Невозможно отменить транзакцию",
                "en" => "You can not cancel the transaction"
            ],
            self::AUTH_ERROR => [
                "uz" => "Avtorizatsiyadan o'tishda xatolik",
                "ru" => "Ошибка аутентификации",
                "en" => "Auth error"
            ],
        };
    }
}
