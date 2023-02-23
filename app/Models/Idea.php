<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Idea extends Model
{
    use HasFactory, Sluggable;

    const PAGINATION_COUNT = 10;

    protected $guarded = [];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function isVotedByUser(?User $user)
    {
        if(!$user){
            return false;
        }
        
        return Vote::where('user_id', $user->id)
            ->where('idea_id', $this->id)
            ->exists();
    }

    // public function getStatusClasses()
    // {
    //     $allStatuses = [
    //         'Open' => 'bg-gray-200',
    //         'Considering' => 'bg-purple text-white',
    //         'In Progress' => 'bg-yellow text-white',
    //         'Implemented' => 'bg-green text-white',
    //         'Closed' => 'bg-red text-white'
    //     ];
        
    //     return $allStatuses[$this->status->name];
    // }
}
