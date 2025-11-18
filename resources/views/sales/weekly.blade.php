<x-layouts.admin>
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h3>{{ $title }}</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover datatable">
                <thead class="table-dark">
                    <tr>
                        <th>Order ID</th>
                        <th>Buyer</th>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ $order->product->title ?? 'N/A' }}</td>
                            <td>{{ $order->quantity }}</td>
                            <td>{{ number_format($order->total_price, 2) }}</td>
                            <td>
                                <span class="badge bg-success">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No sales found.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" class="text-end">Total:</th>
                        <th>{{ number_format($orders->sum('total_price'), 2) }}</th>
                        <th colspan="2"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('.datatable').DataTable({
        dom: 'Bfrtip',
        searching: false,
        buttons: [
            'copy',
            'excel',
            {
                extend: 'pdf',
                title: '{{ $title }}',
                pageSize: 'A4',
                customize: function(doc) {
                    // General style
                    doc.defaultStyle.fontSize = 10;
                    doc.styles.tableHeader.fontSize = 12;
                    doc.styles.title.alignment = 'center';
                    doc.styles.title.bold = true;
                    
                    // Set column widths
                    var colCount = doc.content[1].table.body[0].length;
                    doc.content[1].table.widths = Array(colCount)
                        .fill('*'); // equal width for all columns

                    // Add total at the bottom
                    var total = {{ $orders->sum('total_price') }};
                    doc.content.push({
                        text: '\nTotal Sales: ₱' + total.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits:2}),
                        alignment: 'right',
                        margin: [0, 10, 0, 0],
                        bold: true,
                        fontSize: 12
                    });
                }
            },
            {
                extend: 'print',
                title: '{{ $title }}',
                customize: function (win) {
                    var total = {{ $orders->sum('total_price') }};
                    $(win.document.body).append(
                        '<div style="text-align:right; font-weight:bold; margin-top:10px;">Total Sales: ₱' + total.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits:2}) + '</div>'
                    );
                }
            }
        ],
        pageLength: 10,
        order: [[0, 'desc']]
    });
});
</script>
@endpush

</x-layouts.admin>
