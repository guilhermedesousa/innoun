<?php

namespace Models;

class WorkingHours extends Model
{
    protected static string $table_name = 'working_hours';
    protected static array $columns = ['id', 'user_id', 'work_date', 'time1', 'time2', 'time3', 'time4', 'worked_time'];

    public static function loadFromUserAndDate($userId, $workDate)
    {
        $registry = self::getOne(['user_id' => $userId, 'work_date' => $workDate]);

        if (!$registry) {
            $registry = new WorkingHours([
                'user_id' => $userId,
                'work_date' => $workDate,
                'worked_time' => 0
            ]);
        }

        return $registry;
    }
}