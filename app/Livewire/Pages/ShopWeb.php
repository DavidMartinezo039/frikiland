<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class ShopWeb extends Component
{
    public string $view = 'index';

    public function mount()
    {
        if (request()->routeIs('shop-web.cart')) {
            $this->view = 'cart';
        } elseif (request()->routeIs('shop-web.mine')) {
            $this->view = 'my-products';
        } else {
            $this->view = 'index';
        }
    }

    public function render()
    {
        return view('livewire.pages.shop-web');
    }
}
