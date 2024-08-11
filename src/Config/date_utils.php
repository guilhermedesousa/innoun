<?php

const MONTH_MAP = [
    'January'   => 'Janeiro',
    'February'  => 'Fevereiro',
    'March'     => 'Março',
    'April'     => 'Abril',
    'May'       => 'Maio',
    'June'      => 'Junho',
    'July'      => 'Julho',
    'August'    => 'Agosto',
    'September' => 'Setembro',
    'October'   => 'Outubro',
    'November'  => 'Novembro',
    'December'  => 'Dezembro'
];

function getDateAsDateTime($date): DateTime
{
    return is_string($date) ? new DateTime($date) : $date;
}

function isWeekend($date): string
{
    $inputDate = getDateAsDateTime($date);
    return $inputDate->format('N') >= 6;
}

function isBefore($date1, $date2): bool
{
    $inputDate1 = getDateAsDateTime($date1);
    $inputDate2 = getDateAsDateTime($date2);
    return $inputDate1 <= $inputDate2;
}

function getNextDay($date): DateTime|false
{
    $inputDate = getDateAsDateTime($date);
    $inputDate->modify('+1 day');
    return $inputDate;
}

function getPtMonthName(string $date): string
{
    [$day, $_, $month, $_, $year] = explode(' ', $date);
    return $day . ' de ' . MONTH_MAP[$month] . ' de ' . $year;
}