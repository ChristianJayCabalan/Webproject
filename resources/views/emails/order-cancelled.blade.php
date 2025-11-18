<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Cancelled</title>
</head>
<body>
    <h1>Order Cancelled</h1>

    <p>Dear {{ $order->user->name }},</p>

    <p>We regret to inform you that your order has been <strong>cancelled</strong>.</p>

    <p><strong>Order Details:</strong></p>
    <ul>
        <li><strong>Order ID:</strong> {{ $order->id }}</li>
        <li><strong>Product:</strong> {{ $order->product->title ?? 'N/A' }}</li>
        <li><strong>Quantity:</strong> {{ $order->quantity }}</li>
        <li><strong>Total Price:</strong> ₱{{ number_format($order->total_price, 2) }}</li>
    </ul>

    <p>If you believe this was a mistake, please contact our support team immediately.</p>

    <p>Thank you for understanding.</p>
</body>
</html>
