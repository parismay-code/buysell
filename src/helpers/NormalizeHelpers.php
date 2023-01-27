<?php

namespace BuySell\helpers;

class NormalizeHelpers
{
    /**
     * Возвращает правильную форму слова для числительных
     *
     * @param int $number
     * @param string $one
     * @param string $two
     * @param string $many
     *
     * @return string
     */
    public static function getNounPluralForm(int $number, string $one, string $two, string $many): string
    {
        $mod10 = $number % 10;

        return match (true) {
            $mod10 === 1 => $one,
            $mod10 >= 2 && $mod10 <= 4 => $two,
            default => $many,
        };
    }
}