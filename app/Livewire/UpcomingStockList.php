<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\UpcomingStock;

class UpcomingStockList extends Component
{
    public function render()
    {
        $stocks = UpcomingStock::with('category')
            ->orderBy('expected_arrival', 'asc')
            ->get();

        return view('livewire.upcoming-stock-list', compact('stocks'))
            ->layout('components.layouts.app');
    }
}
