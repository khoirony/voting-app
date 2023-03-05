<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Traits\WithAuthRedirects;

use App\Models\Comment;
use App\Models\Idea;
use App\Notifications\CommentAdded;
use Illuminate\Http\Response;
use Livewire\Component;

class AddComment extends Component
{
    use WithAuthRedirects;

    public $idea;
    public $comment;

    // set validation
    protected $rules = [
        'comment' => 'required|min:4',
    ];

    // get data idea every load
    public function mount(Idea $idea)
    {
        $this->idea = $idea;
    }

    public function addComment()
    {
        // can't access if guest
        if (auth()->guest()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        // run validation
        $this->validate();

        // create comment
        $newComment = Comment::create([
            'user_id' => auth()->id(),
            'idea_id' => $this->idea->id,
            'status_id' => 1,
            'body' => $this->comment,
        ]);

        // reset form comment
        $this->reset('comment');

        // send notif to user who have this idea
        $this->idea->user->notify(new CommentAdded($newComment));

        // send event and payload
        $this->emit('commentWasAdded', 'Comment was posted!');
    }

    public function render()
    {
        return view('livewire.add-comment');
    }
}
