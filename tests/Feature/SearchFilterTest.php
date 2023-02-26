<?php

namespace Tests\Feature;

use App\Http\Livewire\IdeasIndex;
use App\Models\Category;
use App\Models\Idea;
use App\Models\Status;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class SearchFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_searching_works_when_more_than_3_characters()
    {
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        $statusOpen = Status::factory()->create(['name' => 'Open', 'classes' => 'bg-gray-200']);

        $ideaOne = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' =>$statusOpen->id,
            'title' => 'My First Idea',
            'description' => 'Description for my first idea'
        ]);
        $ideaTwo = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' =>$statusOpen->id,
            'title' => 'My Second Idea',
            'description' => 'Description for my second idea'
        ]);
        $ideaThree = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' =>$statusOpen->id,
            'title' => 'My Third Idea',
            'description' => 'Description for my third idea'
        ]);

        Vote::factory()->create([
            'idea_id' => $ideaOne->id,
            'user_id' => $user->id
        ]);

        Livewire::test(IdeasIndex::class)
            ->set('search', 'Second')
            ->assertViewHas('ideas', function($ideas) {
                return $ideas->count() == 1
                    && $ideas->first()->title == 'My Second Idea';
            });
    }

    public function test_does_not_perform_search_if_less_than_3_character()
    {
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        $statusOpen = Status::factory()->create(['name' => 'Open', 'classes' => 'bg-gray-200']);

        $ideaOne = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' =>$statusOpen->id,
            'title' => 'My First Idea',
            'description' => 'Description for my first idea'
        ]);
        $ideaTwo = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' =>$statusOpen->id,
            'title' => 'My Second Idea',
            'description' => 'Description for my second idea'
        ]);
        $ideaThree = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' =>$statusOpen->id,
            'title' => 'My Third Idea',
            'description' => 'Description for my third idea'
        ]);

        Vote::factory()->create([
            'idea_id' => $ideaOne->id,
            'user_id' => $user->id
        ]);

        Livewire::test(IdeasIndex::class)
            ->set('search', 'ab')
            ->assertViewHas('ideas', function($ideas) {
                return $ideas->count() == 3;
            });
    }

    public function test_search_works_correctly_with_category_filters()
    {
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        $statusOpen = Status::factory()->create(['name' => 'Open', 'classes' => 'bg-gray-200']);

        $ideaOne = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' =>$statusOpen->id,
            'title' => 'My First Idea',
            'description' => 'Description for my first idea'
        ]);
        $ideaTwo = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' =>$statusOpen->id,
            'title' => 'My Second Idea',
            'description' => 'Description for my second idea'
        ]);
        $ideaThree = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryTwo->id,
            'status_id' =>$statusOpen->id,
            'title' => 'My Third Idea',
            'description' => 'Description for my third idea'
        ]);

        Livewire::test(IdeasIndex::class)
            ->set('category', 'Category 1')
            ->set('search', 'First')
            ->assertViewHas('ideas', function($ideas) {
                return $ideas->count() == 1;
            });
    }
}
