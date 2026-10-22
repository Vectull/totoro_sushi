<?php

namespace App\Livewire;

use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        return view('livewire.home')->layout('components.layouts.app', [
            'title' => 'Суши и роллы с доставкой — ' . config('app.name'),
            'metaDescription' => 'Заказывайте суши, роллы и сеты с доставкой или самовывозом. Выберите любимые блюда в меню ' . config('app.name') . '.',
        ]);
    }
}
