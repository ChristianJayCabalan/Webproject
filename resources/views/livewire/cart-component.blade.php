<div class="container-fluid mt-4 d-flex flex-column min-vh-100">
    {{-- SweetAlert messages --}}
    @if (session()->has('message'))
        <script>
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "{{ session('message') }}",
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    @endif

    @if (session()->has('error'))
        <script>
            Swal.fire({
                position: "top-end",
                icon: "error",
                title: "{{ session('error') }}",
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    @endif

    <form wire:submit.prevent="confirmOrder" class="d-flex flex-column">
    <div class="product_card w-100 d-flex flex-column">

        {{-- Cart Table --}}
        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center w-100">
                <thead class="thead-dark">
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    @forelse ($cart as $productId => $item)
                        <tr>
                            <td>{{ $item['title'] }}</td>
                            <td>₱{{ number_format($item['price'], 2) }}</td>
                            <td>
                                <input type="number"
                                       wire:model.lazy="cart.{{ $productId }}.quantity"
                                       wire:change="updateQuantity({{ $productId }}, $event.target.value)"
                                       min="1"
                                       class="form-control form-control-sm"
                                       style="width:80px;">
                            </td>
                            <td>₱{{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                            <td>
                                <button type="button"
                                        class="btn btn-warning btn-sm"
                                        wire:click="removeFromCart({{ $productId }})">
                                    Remove
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted fw-bold py-4">
                                🛒 Your cart is empty!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th>Total</th>
                        <td colspan="3"></td>
                        <td>₱{{ number_format($total ?? 0, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>


            {{-- Address Section --}}
<div class="row mt-1 g-4">
    <div class="col-md-3">
        <label class="form-label fw-bold">Province:</label>
        <input type="text" class="form-control form-control-lg" value="Bohol" readonly>
    </div>
    <div class="col-md-3">
        <label class="form-label fw-bold">Municipality:</label>
        <input type="text" class="form-control form-control-lg" value="Talibon" readonly>
    </div>
    <div class="col-md-3">
        <label class="form-label fw-bold">Barangay:</label>
        <select wire:model="barangay" class="form-control form-control-lg">
            <option value="">-- Select Barangay --</option>
            @foreach($barangays as $b)
                <option value="{{ $b }}">{{ $b }}</option>
            @endforeach
        </select>
        @error('barangay') <span class="text-danger fw-bold">{{ $message }}</span> @enderror
    </div>
    <div class="col-md-3">
        <label class="form-label fw-bold">Purok:</label>
        <select wire:model="purok" class="form-control form-control-lg">
            <option value="">-- Select Purok --</option>
            @foreach($puroks as $p)
                <option value="{{ $p }}">{{ $p }}</option>
            @endforeach
        </select>
        @error('purok') <span class="text-danger fw-bold">{{ $message }}</span> @enderror
    </div>
</div>

{{-- Phone Number --}}
<div class="mt-4">
    <label class="form-label fw-bold">Phone Number:</label>
    <input type="text"
           wire:model="phoneNumber"
           class="form-control form-control-lg"
           placeholder="Enter your phone number">
    @error('phoneNumber') <span class="text-danger fw-bold">{{ $message }}</span> @enderror
</div>

{{-- Confirm Button --}}
<div class="mt-5">
    <button type="submit" class="btn btn-primary btn-lg w-100" @if(empty($cart)) disabled @endif>
        Confirm Order
    </button>
</div>


        </div>
    </form>
</div>
