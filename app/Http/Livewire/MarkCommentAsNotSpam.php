<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Illuminate\Http\Response;
use Livewire\Component;

class MarkCommentAsNotSpam extends Component
{
    public Comment $comment;

    protected $listeners = ['setMarkAsNotSpamComment'];

    public function setMarkAsNotSpamComment($commentId)
    {
        // input comment to global variable
        $this->comment = Comment::findOrFail($commentId);

        // send event to open modal
        $this->emit('markAsNotSpamCommentWasSet');
    }

    public function markAsNotSpam()
    {
        if (auth()->guest() || ! auth()->user()->isAdmin()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        // set spam to 0
        $this->comment->spam_reports = 0;
        $this->comment->save();

        // send event to close modal and message
        $this->emit('commentWasMarkedAsNotSpam', 'Comment spam counter was reset!');
    }

    public function render()
    {
        return view('livewire.mark-comment-as-not-spam');
    }
}
