<?php

class OrderStatusEnum {
    private function __construct() {}

    public const ACCEPTED = 0;
    public const SENT = 1;
    public const DELIVERED = 2;
    public const CANCELLED = 3;

    public static function getConstants(){
        return [
            self::ACCEPTED => "Zamówienie przyjęte",
            self::SENT => "Zamówienie wysłane",
            self::DELIVERED => "Zamówienie dostarczone",
            self::CANCELLED => "Zamówienie anulowane",
        ];
    }
}