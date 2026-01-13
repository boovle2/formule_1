<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\RaceModel;
use App\Models\DriverModel;
use App\Models\standings;
use App\Services\PointsCalculator;

class StoreStandingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_store_standings_and_points_are_applied()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $race = RaceModel::create(["name" => "Test GP", "date" => now(), "location" => "Testville"]);

        $d1 = DriverModel::create(['Fname' => 'John', 'Lname' => 'Doe', 'number' => 1, 'points' => 0]);
        $d2 = DriverModel::create(['Fname' => 'Jane', 'Lname' => 'Smith', 'number' => 2, 'points' => 0]);

        $payload = [
            'session_type' => 'race',
            'race_id' => $race->id,
            'session_id' => $race->id,
            'results' => [
                ['driver_id' => $d1->id, 'placement' => 1],
                ['driver_id' => $d2->id, 'placement' => 2],
            ],
        ];

        $this->actingAs($admin)
            ->post(route('standings.store'), $payload)
            ->assertRedirect(route('standings.index'));

        // Assert standings rows created
        $this->assertDatabaseHas('standings', ['race_id' => $race->id, 'driver_id' => $d1->id, 'placement' => 1]);
        $this->assertDatabaseHas('standings', ['race_id' => $race->id, 'driver_id' => $d2->id, 'placement' => 2]);

        // Reload drivers and assert points equal PointsCalculator values
        $d1->refresh();
        $d2->refresh();

        $this->assertEquals(PointsCalculator::pointsForPlacement('race', 1), $d1->points);
        $this->assertEquals(PointsCalculator::pointsForPlacement('race', 2), $d2->points);
    }
}
