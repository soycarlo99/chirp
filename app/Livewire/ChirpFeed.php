<?php

namespace App\Livewire;

use App\Events\ChirpSent;
use App\Models\Chirp;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ChirpFeed extends Component
{
    #[Validate('required|string|max:255')]
    public $message = '';

    public function createChirp()
    {
        $this->validate();

        $chirp = auth()->user()->chirps()->create([
            'message' => $this->message,
        ]);

        // Broadcast the new chirp
        broadcast(new ChirpSent($chirp));

        // Clear the form
        $this->reset('message');

        // Show success message
        session()->flash('success', 'Your chirp has been posted!');
    }

    #[On('echo:public-chirps,.chirp.sent')]
    public function refreshFeed()
    {
        // This will automatically re-render the component
        // when a new chirp is broadcasted
    }

    #[On('chirp-deleted')]
    public function handleChirpDeleted()
    {
        // Refresh the feed when a chirp is deleted
        // Component will re-render automatically
    }

    public function render()
    {
        $chirps = Chirp::with('user')
            ->latest()
            ->take(50)
            ->get();

        return view('livewire.chirp-feed', [
            'chirps' => $chirps,
        ]);
    }
}
