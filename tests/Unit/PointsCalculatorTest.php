<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\PointsCalculator;

class PointsCalculatorTest extends TestCase
{
    public function test_race_first_place_points()
    {
        $this->assertEquals(25, PointsCalculator::pointsForPlacement('race', 1));
    }

    public function test_sprint_first_place_points()
    {
        $this->assertEquals(8, PointsCalculator::pointsForPlacement('sprint', 1));
    }

    public function test_unknown_placement_returns_zero()
    {
        $this->assertEquals(0, PointsCalculator::pointsForPlacement('race', 99));
    }
}
