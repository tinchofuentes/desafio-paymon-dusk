<?php

namespace App\Livewire\Layout;

use Livewire\Component;

class Navigation extends Component
{

    public function logout()
    {
        auth()->guard('web')->logout();
        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.layout.navigation');
    }
} 