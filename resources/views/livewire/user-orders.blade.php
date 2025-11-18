<div class="container mt-4">
    <link rel="stylesheet" href="{{ asset('css/user-order.css') }}">

    <h3 class="fw-bold mb-4 header-animate">
        <i class="fa-solid fa-box me-2"></i> My Orders
    </h3>

    @forelse($orders as $order)
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title">{{ $order->product->title }}</h5>
                    <span class="badge 
                        @if($order->status == 'approved') bg-success
                        @elseif($order->status == 'cancelled') bg-danger
                        @else bg-warning text-dark
                        @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                @if($order->status == 'pending')
                    <p class="text-warning fw-bold mb-2">⏳ Your order is submitted. Waiting for admin approval...</p>
                @elseif($order->status == 'approved')
                    <p class="text-success fw-bold mb-2">✅ Your order has been approved by Admin!</p>
                @elseif($order->status == 'cancelled')
                    <p class="text-danger fw-bold mb-2">❌ Sorry, your order was cancelled.</p>
                @endif

                @if($order->status == 'approved')
                    <p class="mb-1">Qty: <strong>{{ $order->quantity }}</strong></p>
                    <p class="mb-1">Price per Item: ₱{{ number_format($order->price_per_item, 2) }}</p>
                    <p class="mb-1">Total: <strong>₱{{ number_format($order->total_price, 2) }}</strong></p>

                    <small class="text-muted">
                        Ordered on: {{ $order->created_at->format('M d, Y h:i A') }}
                    </small>
                    <br>
                    <small class="text-success">
                        Approved on: {{ $order->updated_at->format('M d, Y h:i A') }}
                    </small>
                @endif
            </div>
        </div>
    @empty
        <p class="text-muted">You have no orders yet.</p>
    @endforelse
</div>
