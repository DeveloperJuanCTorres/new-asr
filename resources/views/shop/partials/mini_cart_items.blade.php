@if(count($cart) > 0)
    @foreach($cart as $item)
        <div class="d-flex mb-3">
            <img src="{{ asset('storage/'.$item['image']) }}" width="50">
            <div class="ms-2">
                <div>{{ $item['name'] }}</div>
                <small>{{ $item['quantity'] }} x S/ {{ $item['price'] }}</small>
            </div>
        </div>
    @endforeach
@else
    <p class="text-muted">Tu carrito está vacío</p>
@endif