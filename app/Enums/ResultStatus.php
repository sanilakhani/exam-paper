<?php

namespace App\Enums;

enum ResultStatus: string
{
    case PASS = 'pass';
    case FAIL = 'fail';

    public function label(): string
    {
        return match($this) {
            self::PASS => 'Passed',
            self::FAIL => 'Failed',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::PASS => 'green',
            self::FAIL => 'red',
        };
    }
}