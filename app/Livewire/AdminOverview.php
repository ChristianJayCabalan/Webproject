<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\UpcomingStock;
use App\Models\Message;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminOverview extends Component
{
    public $totalOrders;
    public $totalProducts;
    public $totalCategories;
    public $totalCustomers;
    public $totalUpcomingStock;
    public $pendingOrders;
    public $unreadMessages = 0;

    // Weekly
    public $weeklyRangeText;
    public $weeklySalesFrequency = [];
    public $totalWeeklySales = 0;

    // Monthly
    public $monthlySalesFrequency = [];
    public $totalMonthlySales = 0;

    // Yearly
    public $yearlySalesFrequency = [];
    public $totalYearlySales = 0;

    public function mount()
    {
        $this->loadOverviewData();
    }

    protected $pollingInterval = 5000;

    public function loadOverviewData()
    {
        // Totals
        $this->totalOrders       = Order::count();
        $this->totalProducts     = Product::count();
        $this->totalCategories   = Category::count();
        $this->totalCustomers    = User::count();
        $this->totalUpcomingStock = UpcomingStock::count();
        $this->pendingOrders     = Order::where('status', 'pending')->count();

        // Unread messages for admin
        $this->unreadMessages = Message::where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->count();

        // -----------------------
        // WEEKLY SALES (Mon–Sun)
        // -----------------------
        $this->weeklySalesFrequency = [];
        $this->totalWeeklySales = 0;

        $startOfWeek = Carbon::now()->startOfWeek(Carbon::MONDAY);
        $endOfWeek   = Carbon::now()->endOfWeek(Carbon::SUNDAY);

        $this->weeklyRangeText = $startOfWeek->format('M j, Y') . ' - ' . $endOfWeek->format('M j, Y');

        $period = Carbon::parse($startOfWeek)->daysUntil($endOfWeek->copy()->addDay());

        foreach ($period as $date) {
            $salesForDay = Order::whereDate('created_at', $date->toDateString())
                ->where('status', 'approved')
                ->sum('total_price');

            $this->weeklySalesFrequency[] = [
                'date'  => $date->format('D, M j'),
                'sales' => $salesForDay,
            ];

            $this->totalWeeklySales += $salesForDay;
        }

        // -----------------------
        // MONTHLY SALES (this year)
        // -----------------------
        $this->monthlySalesFrequency = [];
        $this->totalMonthlySales = 0;

        for ($m = 1; $m <= 12; $m++) {
            $month = Carbon::createFromDate(date('Y'), $m, 1);
            $salesForMonth = Order::whereYear('created_at', date('Y'))
                ->whereMonth('created_at', $m)
                ->where('status', 'approved')
                ->sum('total_price');

            $this->monthlySalesFrequency[] = [
                'month' => $month->format('M'),
                'sales' => $salesForMonth,
            ];

            $this->totalMonthlySales += $salesForMonth;
        }

        // -----------------------
        // YEARLY SALES (last 5 years)
        // -----------------------
        $this->yearlySalesFrequency = [];
        $this->totalYearlySales = 0;

        $currentYear = date('Y');
        for ($y = $currentYear - 4; $y <= $currentYear; $y++) {
            $salesForYear = Order::whereYear('created_at', $y)
                ->where('status', 'approved')
                ->sum('total_price');

            $this->yearlySalesFrequency[] = [
                'year' => $y,
                'sales' => $salesForYear,
            ];

            $this->totalYearlySales += $salesForYear;
        }
    }

    public function loadUnreadMessages()
    {
        $this->unreadMessages = Message::where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->count();
    }
    public function markAllAsRead()
{
    Message::where('receiver_id', Auth::id())
        ->where('is_read', false)
        ->update(['is_read' => true]);

    $this->unreadMessages = 0;
}

public function goToMessages()
{
    return redirect()->route('admin.chat');
}


    public function render()
    {
        return view('livewire.admin-overview')->layout('components.layouts.admin');
    }
}
