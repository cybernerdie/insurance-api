<?php

namespace App\Enums;

enum AgeLoadEnum : string
{
    case AGE_18_30 = "0.6";
    case AGE_31_40 = "0.7";
    case AGE_41_50 = "0.8";
    case AGE_51_60 = "0.9";
    case AGE_61_70 = "1.0";

    public static function fromAge(int $age): self
    {
        return match (true) {
            $age >= 18 && $age <= 30 => self::AGE_18_30,
            $age >= 31 && $age <= 40 => self::AGE_31_40,
            $age >= 41 && $age <= 50 => self::AGE_41_50,
            $age >= 51 && $age <= 60 => self::AGE_51_60,
            $age >= 61 && $age <= 70 => self::AGE_61_70,
            default => throw new \InvalidArgumentException('Age is not in the valid range (18-70).'),
        };
    }
}
