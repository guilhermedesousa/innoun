<?php

namespace Models;

use Exceptions\AppException;
use DateInterval;
use DateTime;
use DateTimeImmutable;

class WorkingHours extends Model
{
    protected static string $table_name = 'working_hours';
    protected static array $columns = ['id', 'user_id', 'work_date', 'time1', 'time2', 'time3', 'time4', 'worked_time'];

    public static function loadFromUserAndDate($userId, $workDate): WorkingHours|Model|null
    {
        $registry = self::getOne(['user_id' => $userId, 'work_date' => $workDate]);

        if (!$registry) {
            $registry = new WorkingHours([
                'user_id' => $userId,
                'work_date' => $workDate,
                'time1' => null,
                'time2' => null,
                'time3' => null,
                'time4' => null,
                'worked_time' => 0
            ]);
        }

        return $registry;
    }

    public function getNextTime(): string|null
    {
        if (!$this->time1) return 'time1';
        if (!$this->time2) return 'time2';
        if (!$this->time3) return 'time3';
        if (!$this->time4) return 'time4';
        return null;
    }

    public function getActiveClock(): string|null
    {
        $nextTime = $this->getNextTime();

        if ($nextTime === 'time1' || $nextTime === 'time3') {
            return 'exitTime';
        } elseif ($nextTime === 'time2' || $nextTime === 'time4') {
            return 'workedTime';
        } else {
            return null;
        }
    }

    public function clockInAndOut($time): void
    {
        $timeColumn = $this->getNextTime();

        if (!$timeColumn) {
            throw new AppException("Limite de batimentos atingido");
        }

        $this->$timeColumn = $time;
        $this->worked_time = getSecondsFromDateInterval($this->getWorkedTime());
        if ($this->id) {
            $this->update();
        } else {
            $this->insert();
        }
    }

    public function getWorkedTime(): DateInterval|false
    {
        [$t1, $t2, $t3, $t4] = $this->getTimes();

        $part1 = new DateInterval('PT0S');
        $part2 = new DateInterval('PT0S');

        if ($t1) $part1 = $t1->diff(new DateTime());
        if ($t2) $part1 = $t1->diff($t2);

        if ($t3) $part2 = $t3->diff(new DateTime());
        if ($t4) $part2 = $t3->diff($t4);

        return sumIntervals($part1, $part2);
    }

    public function getLunchInterval(): DateInterval
    {
        [, $t2, $t3,] = $this->getTimes();

        $lunchInterval = new DateInterval('PT0S');

        if ($t2) $lunchInterval = $t2->diff(new DateTime());
        if ($t3) $lunchInterval = $t2->diff($t3);

        return $lunchInterval;
    }

    public function getExitTime(): DateTimeImmutable
    {
        [$t1,,, $t4] = $this->getTimes();
        $workday = DateInterval::createFromDateString('8 hours');
        $exitTime = new DateTimeImmutable();

        if (!$t1) {
            $exitTime = $exitTime->add($workday);
        } elseif ($t4) {
            $exitTime = $t4;
        } else {
            $exitTime = $t1->add(sumIntervals($workday, $this->getLunchInterval()));
        }

        return $exitTime;
    }

    function getBalance(): string
    {
        if (!$this->time1 && !isPastWorkday($this->work_date)) return '';
        if ($this->worked_time == DAILY_TIME) return '';

        $balance = $this->worked_time - DAILY_TIME;
        $balanceString = getTimeStringFromSeconds(abs($balance));
        $sign = $this->worked_time >= DAILY_TIME ? '+' : '-';
        return "{$sign}{$balanceString}";
    }

    public static function getMonthlyReport($userId, $date): array
    {
        $registries = [];
        $startDate = getFirstDayOfMonth($date)->format('Y-m-d');
        $endDate = getLastDayOfMonth($date)->format('Y-m-d');

        $result = static::getResultFromSelect([
            'user_id' => $userId,
            'raw' => "work_date between '{$startDate}' AND '{$endDate}'"
        ]);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $registries[$row['work_date']] = new WorkingHours($row);
            }
        }

        return $registries;
    }

    private function getTimes(): array
    {
        $times = [];

        $times[] = $this->time1 ? dateFromString($this->time1) : null;
        $times[] = $this->time2 ? dateFromString($this->time2) : null;
        $times[] = $this->time3 ? dateFromString($this->time3) : null;
        $times[] = $this->time4 ? dateFromString($this->time4) : null;

        return $times;
    }
}