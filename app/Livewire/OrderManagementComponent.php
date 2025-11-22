<?php

namespace App\Livewire;

use App\Mail\OrderApprovedMail;
use App\Mail\OrderCancelledMail;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithPagination;

class OrderManagementComponent extends Component
{
    use WithPagination;

    public $search = ''; // 🔍 search text

    /**
     * Approve order
     */
    public function approveOrder($orderId)
    {
        $order = Order::with(['user', 'product'])->find($orderId);

        if ($order) {
            // ✅ Mark as approved and unread for user
            $order->update([
                'status' => 'approved',
                'is_read' => false,
            ]);

            // Send notification email to user
            Mail::to($order->user->email)->send(new OrderApprovedMail($order));

            session()->flash('message', "Order #{$order->id} approved successfully, and the user has been notified.");
        } else {
            session()->flash('error', "Order #{$orderId} not found.");
        }
    }

    /**
     * Cancel order
     */
    public function cancelOrder($orderId)
    {
        $order = Order::with('user')->find($orderId);

        if ($order->status === 'approved') {
            session()->flash('error', "Order #{$order->id} is already approved and cannot be cancelled.");
            return;
        }

        $order->update(['status' => 'cancelled']);

        // Notify user
        Mail::to($order->user->email)->send(new OrderCancelledMail($order));

        session()->flash('message', "Order #{$order->id} cancelled successfully, and the user has been notified.");
    }

    /**
     * Search/filter trigger
     */
    public function applyFilter()
    {
        // Forces re-render with current search value
    }

    /**
     * Render component
     */
    public function render()
    {
        $orders = Order::with(['product', 'user'])
            ->when($this->search, function ($query) {
                $query->whereDate('created_at', $this->search)
                      ->orWhereHas('user', fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
                      ->orWhereHas('product', fn($q) => $q->where('title', 'like', '%' . $this->search . '%'));
            })
            ->latest()
            ->paginate(10);

        return view('livewire.order-management-component', [
            'orders' => $orders,
        ])->layout('components.layouts.admin');
    }
}
