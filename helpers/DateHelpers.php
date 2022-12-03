<?php

namespace app\helpers;

class DateHelpers
{
    const MONTHS_MAP = [
        ".01." => "января", ".02." => "февраля",
        ".03." => "марта", ".04." => "апреля", ".05." => "мая", ".06." => "июня",
        ".07." => "июля", ".08." => "августа", ".09." => "сентября",
        ".10." => "октября", ".11." => "ноября", ".12." => "декабря"
    ];

    /**
     * @throws Exception
     */
    static public function formatDate(string $date): string
    {
        $timestamp = strtotime($date);

        $day = date('d', $timestamp);
        $month = self::MONTHS_MAP[date('.m.', $timestamp)];
        $year = date('Y', $timestamp);

        return "$day $month $year";
    }
}