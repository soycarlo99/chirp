<?php

namespace App\Livewire;

use App\Models\Chirp;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ChirpItem extends Component
{
    public Chirp $chirp;
    public bool $editing = false;

    #[Validate('required|string|max:255')]
    public $message = '';

    public function mount(Chirp $chirp)
    {
        $this->chirp = $chirp;
        $this->message = $chirp->message;
    }

    public function startEditing()
    {
        $this->authorize('update', $this->chirp);
        $this->editing = true;
        $this->message = $this->chirp->message;
    }

    public function cancelEdit()
    {
        $this->editing = false;
        $this->message = $this->chirp->message;
        $this->resetErrorBag();
    }

    public function updateChirp()
    {
        $this->authorize('update', $this->chirp);
        $this->validate();

        $this->chirp->update([
            'message' => $this->message,
        ]);

        $this->editing = false;
        session()->flash('success', 'Chirp updated!');
    }

    public function deleteChirp()
    {
        $this->authorize('delete', $this->chirp);

        $this->chirp->delete();

        session()->flash('success', 'Chirp deleted!');

        // Dispatch event to parent to refresh
        $this->dispatch('chirp-deleted');
    }

    public function render()
    {
        return view('livewire.chirp-item');
    }
}
