<?php

namespace App\Traits\Enums;

trait ToArray
{
    /**
     * Преобразовать в массив
     *
     * @return array<string, string|int>
     */
    public static function toArray(): array
    {
        return array_reduce(
            self::cases(),
            function ($carry, $case) {
                $carry[$case->value] = $case->name;
                return $carry;
            },
            []
        );
    }

    /**
     * Получить ключи
     */
    public static function keys(): array
    {
        return array_keys(static::toArray());
    }

    /**
     * Получить значения
     */
    public static function values(): array
    {
        return array_values(static::toArray());
    }

    /**
     * Соединить значения массива
     */
    public static function implode(string $separator = ''): string
    {
        return implode($separator, static::values());
    }
}

