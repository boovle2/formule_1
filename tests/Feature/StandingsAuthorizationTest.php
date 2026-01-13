<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StandingsAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_cannot_open_enter_results()
    {
        $user = User::factory()->create(['role' => 'user']);

        $this->actingAs($user)
            ->get(route('standings.create'))
            ->assertStatus(403);
    }

    public function test_admin_can_open_enter_results()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get(route('standings.create'))
            ->assertStatus(200);
    }
}
