<?php

namespace App\Livewire\Costumer;

use App\Models\Product;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;


class Shop extends Component
{
    use WithPagination;
    #[Url]
    public $search = '';
    public $category_id = '';
    protected $paginationTheme = "bootstrap";

    public function render()
    {
        // Dapatkan semua buku jika tidak ada search dan category
        if (!$this->search && !$this->category_id) {
            $products = Product::latest()->get();
        }

        // Dapatkan buku berdasarkan search
        elseif ($this->search && !$this->category_id) {
            $products = Product::where('title', 'like', '%' . $this->search . '%')->latest()->get();
        }

        // Dapatkan buku berdasarkan category
        elseif (!$this->search && $this->category_id) {
            $products = Product::where('category_id', $this->category_id)->latest()->get();
        }

        // Dapatkan buku berdasarkan search dan category
        else {
            $products = Product::where('title', 'like', '%' . $this->search . '%')->where('category_id', $this->category_id)->latest()->get();
        }
        return view('livewire.costumer.shop', [
            'products' => $products,
            'categories' => Category::get(),
        ]);
    }
}
