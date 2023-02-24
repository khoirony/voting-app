<?php

namespace App\Http\Livewire;

use App\Models\Idea;
use App\Models\Status;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class StatusFilters extends Component
{
    public $status;
    public $statusCount;

    // protected $queryString = [
    //     'status',
    // ];

    public function mount()
    {
        $this->statusCount = Status::getCount();
        $this->status = request()->status ?? 'All';

        if(Route::currentRouteName() == 'idea.show'){
            $this->status = null;
            // $this->queryString = [];
        }
    }

    public function setStatus($newStatus)
    {
        $this->status = $newStatus;
        $this->emit('queryStringUpdatedStatus', $this->status);

        if($this->getPreviousRootName() == 'idea.show'){
            return redirect()->route('idea.index', [
                'status' => $this->status
            ]);
        }

    }

    public function render()
    {
        return view('livewire.status-filters');
    }

    public function getPreviousRootName()
    {
        return app('router')->getRoutes()->match(app('request')->create(url()->previous()))->getName();
    }
}
