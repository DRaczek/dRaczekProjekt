<?php

class StatusEnum {
    private function __construct() {}

    public const INACTIVE = 0;
    public const ACTIVE = 1;
    public const SUSPENDED = 2;

    public static function getConstants(){
        return [
            self::INACTIVE => "Nieaktywny",
            self::ACTIVE => "Aktywny",
            self::SUSPENDED => "Zawieszony",
        ];
    }
}