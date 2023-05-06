<?php

namespace App\Http\Livewire;

use Livewire\Component;

class WishlistComponentIcon extends Component
{
    protected $listeners = ['refreshComponent'=>'$refresh'];
    public function render()
    {
        return view('livewire.wishlist-component-icon');
    }
}
