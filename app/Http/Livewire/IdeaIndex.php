<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Traits\WithAuthRedirects;
use App\Exceptions\DuplicateVoteException;
use App\Exceptions\VoteNotFoundException;
use App\Models\Idea;
use Livewire\Component;

class IdeaIndex extends Component
{
    use WithAuthRedirects;

    public $idea, $votesCount, $hasVoted;

    public function mount(Idea $idea, $votesCount)
    {
        $this->idea = $idea;
        $this->votesCount = $votesCount;
        $this->hasVoted = $idea->voted_by_user;
    }

    public function vote()
    {
        if (auth()->guest()) {
            return $this->redirectToLogin();
        }

        if($this->hasVoted){                                //if user has vote then remove vote and decrement votecount
            try {
                $this->idea->removeVote(auth()->user());
            } catch (VoteNotFoundException $e){
                // do nothing
            }
            $this->votesCount--;
            $this->hasVoted = false;
        }else{                                              //if user not vote then send user data to idea->vote
            try {
                $this->idea->vote(auth()->user());
            } catch (DuplicateVoteException $e){
                // do nothing
            }
            $this->votesCount++;
            $this->hasVoted = true;
        }
    }

    public function render()
    {
        return view('livewire.idea-index');
    }
}
