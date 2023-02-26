<?php

namespace Tests\Feature;

use App\Http\Livewire\IdeasIndex;
use App\Models\Category;
use App\Models\Idea;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CategoryFiltersTest extends TestCase
{
    use RefreshDatabase;

    public function test_selecting_a_category_filters_correctly()
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
            ->assertViewHas('ideas', function($ideas) {
                return $ideas->count() == 2
                    && $ideas->first()->category->name == 'Category 1';
            });
    }

    public function test_the_category_query_string_filters_correctly()
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

        Livewire::withQueryParams(['category' => 'Category 1'])
            ->test(IdeasIndex::class)
            ->set('category', 'Category 1')
            ->assertViewHas('ideas', function($ideas) {
                return $ideas->count() == 2
                    && $ideas->first()->category->name == 'Category 1';
            });
    }

    public function test_selecting_a_status_and_a_category_filters_correctly()
    {
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        $statusOpen = Status::factory()->create(['name' => 'Open', 'classes' => 'bg-gray-200']);
        $statusConsidering = Status::factory()->create(['name' => 'Considering', 'classes' => 'bg-purple']);

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
            'status_id' =>$statusConsidering->id,
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
        $ideaThree = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryTwo->id,
            'status_id' =>$statusConsidering->id,
            'title' => 'My Third Idea',
            'description' => 'Description for my third idea'
        ]);

        Livewire::test(IdeasIndex::class)
            ->set('status', 'Open')
            ->set('category', 'Category 1')
            ->assertViewHas('ideas', function($ideas) {
                return $ideas->count() == 1
                    && $ideas->first()->category->name == 'Category 1'
                    && $ideas->first()->status->name == 'Open';
            });
    }

    public function test_category_query_string_filters_correctly_with_status_and_category()
    {
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        $statusOpen = Status::factory()->create(['name' => 'Open', 'classes' => 'bg-gray-200']);
        $statusConsidering = Status::factory()->create(['name' => 'Considering', 'classes' => 'bg-purple']);

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
            'status_id' =>$statusConsidering->id,
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
        $ideaFour = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryTwo->id,
            'status_id' =>$statusConsidering->id,
            'title' => 'My Fourth Idea',
            'description' => 'Description for my third idea'
        ]);

        Livewire::withQueryParams(['status' => 'Open', 'category' => 'Category 1'])
            ->test(IdeasIndex::class)
            // ->set('category', 'Category 1')
            ->assertViewHas('ideas', function($ideas) {
                return $ideas->count() == 1
                    && $ideas->first()->category->name == 'Category 1'
                    && $ideas->first()->status->name == 'Open';
            });
    }

    public function test_selecting_all_categories_filters_correctly()
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
            ->set('category', 'All Categories')
            ->assertViewHas('ideas', function($ideas) {
                return $ideas->count() == 3;
            });
    }

}
