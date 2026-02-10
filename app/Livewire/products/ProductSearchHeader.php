<?php

namespace App\Livewire\Products;

use Livewire\Component;

class ProductSearchHeader extends Component
{
    public $search = '';

    public function updatedSearch()
    {
        $this->dispatch('search-products', search: $this->search);
    }

    public function render()
    {
        return view('livewire.products.product-search-header');
    }
}
