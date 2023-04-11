<?php

class ProductColourEnum {
    private function __construct() {}

    public const BLACK = 0;
    public const WHITE = 1;
    public const RED = 2;
    public const BLUE = 3;
    public const GREEN = 4;
    public const PURPLE = 5;
    public const YELLOW = 6;
    public const OTHER = 7;

    public static function getConstants(){
        return [
            self::BLACK => "BLACK",
            self::WHITE => "WHITE",
            self::RED => "RED",
            self::BLUE => "BLUE",
            self::GREEN => "GREEN",
            self::PURPLE => "PURPLE",
            self::YELLOW => "YELLOW",
            self::OTHER => "OTHER"
        ];
    }
}