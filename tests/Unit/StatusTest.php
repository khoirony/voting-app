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
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);

        $statusOpen = Status::factory()->create(['name' => 'Open', 'classes' => 'bg-gray-200']);
        $statusConsidering = Status::factory()->create(['name' => 'Considering', 'classes' => 'bg-purple text-white']);
        $statusInProgress = Status::factory()->create(['name' => 'In Progress', 'classes' => 'bg-yellow text-white']);
        $statusImplemented = Status::factory()->create(['name' => 'Implemented', 'classes' => 'bg-green text-white']);
        $statusClosed = Status::factory()->create(['name' => 'Closed', 'classes' => 'bg-red text-white']);

        Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' =>$statusOpen->id,
        ]);
        Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' =>$statusConsidering->id,
        ]);
        Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' =>$statusInProgress->id,
        ]);
        Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' =>$statusImplemented->id,
        ]);
        Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
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
