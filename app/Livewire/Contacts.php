<?php

namespace App\Livewire;

use Livewire\Component;

class Contacts extends Component
{
    public function render()
    {
        return view('livewire.contacts')
            ->layout('components.layouts.app', [
                'title' => 'Контакты — ' . config('app.name'),
                'metaDescription' => 'Контакты и информация о доставке ' . config('app.name') . '.',
            ]);
    }
}
