<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Idea;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_count_of_each_status()
    {
        $statusOpen = Status::factory()->create(['name' => 'Open']);
        $statusConsidering = Status::factory()->create(['name' => 'Considering']);
        $statusInProgress = Status::factory()->create(['name' => 'In Progress']);
        $statusImplemented = Status::factory()->create(['name' => 'Implemented']);
        $statusClosed = Status::factory()->create(['name' => 'Closed']);

        Idea::factory()->create([
            'status_id' =>$statusOpen->id,
        ]);
        Idea::factory()->create([
            'status_id' =>$statusConsidering->id,
        ]);
        Idea::factory()->create([
            'status_id' =>$statusInProgress->id,
        ]);
        Idea::factory()->create([
            'status_id' =>$statusImplemented->id,
        ]);
        Idea::factory()->create([
            'status_id' =>$statusClosed->id,
        ]);

        $this->assertEquals(5, Status::getCount()['all_statuses']);
        $this->assertEquals(1, Status::getCount()['open']);
        $this->assertEquals(1, Status::getCount()['considering']);
        $this->assertEquals(1, Status::getCount()['in_progress']);
        $this->assertEquals(1, Status::getCount()['implemented']);
        $this->assertEquals(1, Status::getCount()['closed']);
    }
}
