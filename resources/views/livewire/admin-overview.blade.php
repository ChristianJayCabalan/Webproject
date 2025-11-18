<div>
    <!-- Row: All Totals Side-by-Side -->
    <div class="row g-3">
        <!-- Total Orders with Pending Notification -->
        <div class="col-6 col-md-4 col-lg-4 position-relative">
            <div class="dashstat h-100 position-relative">
                <i class="fa-solid fa-cart-shopping"></i>
                
                @if($pendingOrders > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $pendingOrders }}
                        <span class="visually-hidden">pending orders</span>
                    </span>
                @endif

                <div class="dashstat_content">
                    <h3>{{ $totalOrders }}</h3>
                    <p>Total Orders</p>
                </div>
            </div>
        </div>

        <!-- Total Products -->
        <div class="col-6 col-md-4 col-lg-4">
            <div class="dashstat h-100">
                <i class="fa-solid fa-tag"></i>
                <div class="dashstat_content">
                    <h3>{{ $totalProducts }}</h3>
                    <p>Total Products</p>
                </div>
            </div>
        </div>

        <!-- Total Categories -->
        <div class="col-6 col-md-4 col-lg-4">
            <div class="dashstat h-100">
                <i class="fa-solid fa-list-ul"></i>
                <div class="dashstat_content">
                    <h3>{{ $totalCategories }}</h3>
                    <p>Total Categories</p>
                </div>
            </div>
        </div>

        <!-- Total Customers -->
<div class="col-6 col-md-4 col-lg-6">
    <a href="{{ route('admin.customers') }}" style="text-decoration: none; color: inherit;">
        <div class="dashstat special h-100">
            <i class="fa-solid fa-users"></i>
            <div class="dashstat_content">
                <h3>{{ $totalCustomers }}</h3>
                <p>Total Customers</p>
            </div>
        </div>
    </a>
</div>

<!-- Upcoming Stock -->
<div class="col-6 col-md-4 col-lg-6">
    <div class="dashstat special h-100">
        <i class="fa-solid fa-boxes-stacked"></i>
        <div class="dashstat_content">
            <h3>{{ $totalUpcomingStock }}</h3>
            <p>Total Upcoming Products</p>
        </div>
    </div>
</div>



    <!-- Sales Section -->
    <div class="row mt-4">
        <!-- Weekly Sales -->
        <div class="col-lg-4 mb-4">
            <div class="dashstat h-100">
                <i class="fa-solid fa-chart-bar"></i>
                <div class="dashstat_content">
                    <h4 class="text-center">Weekly Sales</h4>
                    <p class="text-center text-muted" style="font-size: 0.9rem;">
                        {{ $weeklyRangeText }}
                    </p>
                    <canvas id="weeklySalesChart" height="200"></canvas>
                    <h6 class="mt-3 text-center">
                        Total: <strong>${{ number_format($totalWeeklySales, 2) }}</strong>
                    </h6>
                    <a href="{{ route('sales.weekly') }}" class="btn btn-primary mt-3">
                        View Product Sales
                    </a>
                </div>
            </div>
        </div>

        <!-- Monthly Sales -->
        <div class="col-lg-4 mb-4">
            <div class="dashstat h-100">
                <i class="fa-solid fa-chart-line"></i>
                <div class="dashstat_content">
                    <h4 class="text-center">Monthly Sales</h4>
                    <canvas id="monthlySalesChart" height="200"></canvas>
                    <h6 class="mt-3 text-center">
                        Total: <strong>${{ number_format($totalMonthlySales, 2) }}</strong>
                    </h6>
                    <a href="{{ route('sales.monthly') }}" class="btn btn-success mt-3">
                        View Product Sales
                    </a>
                </div>
            </div>
        </div>

        <!-- Yearly Sales -->
        <div class="col-lg-4 mb-4">
            <div class="dashstat h-100">
                <i class="fa-solid fa-chart-area"></i>
                <div class="dashstat_content">
                    <h4 class="text-center">Yearly Sales</h4>
                    <canvas id="yearlySalesChart" height="200"></canvas>
                    <h6 class="mt-3 text-center">
                        Total: <strong>${{ number_format($totalYearlySales, 2) }}</strong>
                    </h6>
                    <a href="{{ route('sales.yearly') }}" class="btn btn-warning mt-3">
                        View Product Sales
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // ===== WEEKLY =====
        const weeklyCtx = document.getElementById('weeklySalesChart').getContext('2d');
        const weeklyLabels = @json(array_column($weeklySalesFrequency, 'date'));
        const weeklyData = @json(array_column($weeklySalesFrequency, 'sales'));

        const weeklyGradient = weeklyCtx.createLinearGradient(0, 0, 0, 400);
        weeklyGradient.addColorStop(0, 'rgba(0, 123, 255, 0.5)');
        weeklyGradient.addColorStop(1, 'rgba(0, 123, 255, 0)');

        new Chart(weeklyCtx, {
            type: 'line',
            data: {
                labels: weeklyLabels,
                datasets: [{
                    data: weeklyData,
                    fill: true,
                    backgroundColor: weeklyGradient,
                    borderColor: '#007bff',
                    tension: 0.5,
                    pointBackgroundColor: '#007bff',
                    pointRadius: 5
                }]
            },
            options: { responsive: true, plugins: { legend: { display: false }}, scales: { y: { beginAtZero: true }}}
        });

        // ===== MONTHLY =====
        const monthlyCtx = document.getElementById('monthlySalesChart').getContext('2d');
        const monthlyLabels = @json(array_column($monthlySalesFrequency, 'month'));
        const monthlyData = @json(array_column($monthlySalesFrequency, 'sales'));

        const monthlyGradient = monthlyCtx.createLinearGradient(0, 0, 0, 400);
        monthlyGradient.addColorStop(0, 'rgba(40, 167, 69, 0.5)');
        monthlyGradient.addColorStop(1, 'rgba(40, 167, 69, 0)');

        new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: monthlyLabels,
                datasets: [{
                    data: monthlyData,
                    fill: true,
                    backgroundColor: monthlyGradient,
                    borderColor: '#28a745',
                    tension: 0.5,
                    pointBackgroundColor: '#28a745',
                    pointRadius: 5
                }]
            },
            options: { responsive: true, plugins: { legend: { display: false }}, scales: { y: { beginAtZero: true }}}
        });

        // ===== YEARLY =====
        const yearlyCtx = document.getElementById('yearlySalesChart').getContext('2d');
        const yearlyLabels = @json(array_column($yearlySalesFrequency, 'year'));
        const yearlyData = @json(array_column($yearlySalesFrequency, 'sales'));

        const yearlyGradient = yearlyCtx.createLinearGradient(0, 0, 0, 400);
        yearlyGradient.addColorStop(0, 'rgba(255, 193, 7, 0.5)');
        yearlyGradient.addColorStop(1, 'rgba(255, 193, 7, 0)');

        new Chart(yearlyCtx, {
            type: 'line',
            data: {
                labels: yearlyLabels,
                datasets: [{
                    data: yearlyData,
                    fill: true,
                    backgroundColor: yearlyGradient,
                    borderColor: '#ffc107',
                    tension: 0.5,
                    pointBackgroundColor: '#ffc107',
                    pointRadius: 5
                }]
            },
            options: { responsive: true, plugins: { legend: { display: false }}, scales: { y: { beginAtZero: true }}}
        });
    </script>
</div>
