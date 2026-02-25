<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class ShopWeb extends Component
{
    public string $view = 'index';

    public function render()
    {
        return view('livewire.pages.shop-web');
    }
}
