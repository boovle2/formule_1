<?php

namespace App\Services;

class PointsCalculator
{
    // Main race points
    public static array $racePointsTable = [
        1 => 25,
        2 => 18,
        3 => 15,
        4 => 12,
        5 => 10,
        6 => 8,
        7 => 6,
        8 => 4,
        9 => 2,
        10 => 1,
    ];

    // Sprint points
    public static array $sprintPointsTable = [
        1 => 8,
        2 => 7,
        3 => 6,
        4 => 5,
        5 => 4,
        6 => 3,
        7 => 2,
        8 => 1,
    ];

    public static function getPointsTable(string $sessionType): array
    {
        return $sessionType === 'sprint' ? self::$sprintPointsTable : self::$racePointsTable;
    }

    public static function pointsForPlacement(string $sessionType, int $placement): int
    {
        $table = self::getPointsTable($sessionType);
        return $table[$placement] ?? 0;
    }
}
