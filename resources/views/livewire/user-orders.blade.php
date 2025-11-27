<div class="container mt-4 d-flex flex-column justify-content-start min-vh-100">
    <link rel="stylesheet" href="{{ asset('css/user-order.css') }}">

    <h3 class="fw-bold mb-4 header-animate">
        <i class="fa-solid fa-box me-2"></i> My Orders
    </h3>

    <div class="flex-grow-1">
        @forelse($orders as $order)
            <div class="card order-card mb-3 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h2 class="card-title mb-1">{{ $order->product->title }}</h2>

                        <!-- Modern status badge -->
                        <div class="status-wrapper">
                            @if($order->status == 'pending')
                                <span class="status-badge pending">⏳ Pending</span>
                            @elseif($order->status == 'approved')
                                <span class="status-badge approved">✅ Approved</span>
                            @elseif($order->status == 'cancelled')
                                <span class="status-badge cancelled">❌ Cancelled</span>
                            @endif
                        </div>
                    </div>

                    <!-- Status message -->
                    <div class="status-message mb-2">
                        @if($order->status == 'pending')
                            <p class="text-warning fw-bold mb-0">Your order is submitted. Waiting for admin approval...</p>
                        @elseif($order->status == 'approved')
                            <p class="text-success fw-bold mb-0">Your order has been approved by Admin!</p>
                        @elseif($order->status == 'cancelled')
                            <p class="text-danger fw-bold mb-0">Sorry, your order was cancelled.</p>
                        @endif
                    </div>

                    <!-- Approved order details -->
                    @if($order->status == 'approved')
                        <div class="order-details mt-2">
                            <p class="mb-1">Qty: <strong>{{ $order->quantity }}</strong></p>
                            <p class="mb-1">Price per Item: ₱{{ number_format($order->price_per_item, 2) }}</p>
                            <p class="mb-1">Total: <strong>₱{{ number_format($order->total_price, 2) }}</strong></p>

                            <small class="text-muted">Ordered on: {{ $order->created_at->format('M d, Y h:i A') }}</small>
                            <br>
                            <small class="text-success">Approved on: {{ $order->updated_at->format('M d, Y h:i A') }}</small>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="d-flex justify-content-center align-items-center" style="height: 60vh;">
                <p class="text-muted fs-5">You have no orders yet.</p>
            </div>
        @endforelse
    </div>
</div>
