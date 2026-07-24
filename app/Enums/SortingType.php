<?php

namespace App\Enums;

enum SortingType: string
{
    case CreatedAt = 'created_at';
    case Title = 'title';

    public static function default(): self
    {
        return self::CreatedAt;
    }
}
