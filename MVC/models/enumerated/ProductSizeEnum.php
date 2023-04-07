<?php

class ProductSizeEnum {
    private function __construct() {}

    public const XS = 0;
    public const S = 1;
    public const M = 2;
    public const L = 3;
    public const XL = 4;
    public const XXL = 5;

    public static function getConstants(){
        return [
            self::XS => "XS",
            self::S => "S",
            self::M => "M",
            self::L => "L",
            self::XL => "XL",
            self::XXL => "XXL",
        ];
    }
}