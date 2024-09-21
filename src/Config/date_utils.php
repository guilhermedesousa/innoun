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

function sumIntervals($interval1, $interval2): DateInterval|false
{
    $date = new DateTime('00:00:00');
    $date->add($interval1);
    $date->add($interval2);
    return (new DateTime('00:00:00'))->diff($date);
}

function subtractIntervals($interval1, $interval2): DateInterval|false
{
    $date = new DateTime('00:00:00');
    $date->add($interval1);
    $date->sub($interval2);
    return (new DateTime('00:00:00'))->diff($date);
}

function dateFromInterval($interval): DateTimeImmutable
{
    return new DateTimeImmutable($interval->format('H:i:s'));
}

function dateFromString($date): DateTimeImmutable|false
{
    return DateTimeImmutable::createFromFormat('H:i:s', $date);
}

function getFirstDayOfMonth($date): DateTime
{
    $time = getDateAsDateTime($date)->getTimestamp();
    return new DateTime(date('Y-m-1', $time));
}

function getLastDayOfMonth($date): DateTime
{
    $time = getDateAsDateTime($date)->getTimestamp();
    return new DateTime(date('Y-m-t', $time));
}

function getSecondsFromDateInterval($interval): int
{
    $d1 = new DateTimeImmutable();
    $d2 = $d1->add($interval);
    return $d2->getTimestamp() - $d1->getTimestamp();
}

function isPastWorkday($date): bool
{
    return !isWeekend($date) && isBefore($date, new DateTime());
}

function getTimeStringFromSeconds($seconds): string
{
    $h = intdiv($seconds, 3600);
    $m = intdiv($seconds % 3600, 60);
    $s = $seconds - ($h * 3600) - ($m * 60);
    return sprintf('%02d:%02d:%02d', $h, $m, $s);
}

function formatDateWithLocale($date, $pattern): false|string
{
    $time = getDateAsDateTime($date)->getTimestamp();
    return strftime($pattern, $time);
}