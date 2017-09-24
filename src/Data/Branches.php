<?php
namespace M2t\Data;

class Branches
{
    public static $branches = [
        "2.0.2",
        "2.0.7",
        "Head",
    ];

    public static function branches()
    {
        return self::$branches;
    }
}
