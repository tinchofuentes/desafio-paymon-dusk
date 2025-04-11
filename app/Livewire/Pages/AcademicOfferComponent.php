<?php

namespace App\Livewire\Pages;

use App\Models\Academy;
use Livewire\Component;

class AcademicOfferComponent extends Component
{
    public function render()
    {
        return view('livewire.pages.academic-offer-component', [
            'academies' => Academy::with(['courses' => function($query) {
                return $query->where('active', true);
            }])->where('active', true)->get()
        ]);
    }
}
