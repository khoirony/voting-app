<?php

namespace Tests\Feature\Filters;

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
        $ideaOne = Idea::factory()->create([
            'title' => 'My First Idea',
        ]);
        $ideaTwo = Idea::factory()->create([
            'title' => 'My Second Idea',
        ]);
        $ideaThree = Idea::factory()->create([
            'title' => 'My Third Idea',
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

        $ideaOne = Idea::factory()->create([
            'title' => 'My First Idea',
        ]);
        $ideaTwo = Idea::factory()->create([
            'title' => 'My Second Idea',
        ]);
        $ideaThree = Idea::factory()->create([
            'title' => 'My Third Idea',
        ]);

        Livewire::test(IdeasIndex::class)
            ->set('search', 'ab')
            ->assertViewHas('ideas', function($ideas) {
                return $ideas->count() == 3;
            });
    }

    public function test_search_works_correctly_with_category_filters()
    {
        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        $statusOpen = Status::factory()->create(['name' => 'Open']);

        $ideaOne = Idea::factory()->create([
            'category_id' => $categoryOne->id,
            'title' => 'My First Idea',
        ]);
        $ideaTwo = Idea::factory()->create([
            'category_id' => $categoryOne->id,
            'title' => 'My Second Idea',
        ]);
        $ideaThree = Idea::factory()->create([
            'category_id' => $categoryTwo->id,
            'title' => 'My Third Idea',
        ]);

        Livewire::test(IdeasIndex::class)
            ->set('category', 'Category 1')
            ->set('search', 'First')
            ->assertViewHas('ideas', function($ideas) {
                return $ideas->count() == 1;
            });
    }
}
