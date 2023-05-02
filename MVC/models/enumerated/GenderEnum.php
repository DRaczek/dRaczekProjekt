<?php

class GenderEnum {
    private function __construct() {}

    public const MALE = 0;
    public const FEMALE = 1;
    public const UNISEX = 2;

    public static function getConstants(){
        return [
            self::MALE => "Męskie",
            self::FEMALE => "Damskie",
            self::UNISEX => "Unisex",
        ];
    }
}