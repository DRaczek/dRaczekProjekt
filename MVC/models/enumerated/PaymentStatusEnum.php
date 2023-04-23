<?php

class PaymentStatusEnum {
    private function __construct() {}

    public const UNPAID = 0;
    public const PAID = 1;

    public static function getConstants(){
        return [
            self::UNPAID => "Płatność nieopłacona",
            self::PAID => "Płatność opłacona"
        ];
    }
}