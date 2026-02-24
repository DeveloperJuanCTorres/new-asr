@extends('layouts.app')

@section('content')

@include('componentes.header')

<div class="container py-5">

    <div class="row">

        <!-- IZQUIERDA -->
        <div class="col-lg-7">

            <h4 class="mb-4">Finalizar Pedido</h4>

            <form action="{{ route('orders.store') }}" method="POST">
                @csrf

                <div class="card p-4 mb-4">
                    <h6>Datos de envío</h6>

                    <input type="text" name="name" class="form-control mb-3"
                           placeholder="Nombre completo" required>

                    <input type="text" name="phone" class="form-control mb-3"
                           placeholder="Teléfono" required>

                    <input type="text" name="address" class="form-control mb-3"
                           placeholder="Dirección" required>

                    <select name="department" class="form-control mb-3" required>
                        <option value="">Departamento</option>
                        <option>Lima</option>
                        <option>Arequipa</option>
                    </select>

                    <textarea name="notes" class="form-control"
                              placeholder="Notas adicionales"></textarea>
                </div>

                <button class="btn btn-warning w-100 py-3">
                    Confirmar Pedido
                </button>

        </div>

        <!-- DERECHA -->
        <div class="col-lg-5">

            <div class="order-summary p-4">

                <h6>Resumen del pedido</h6>

                @php $subtotal = 0; @endphp

                @foreach(session('cart', []) as $item)
                    @php
                        $subtotal += $item['price'] * $item['quantity'];
                    @endphp

                    <div class="d-flex justify-content-between mb-2">
                        <small>{{ $item['name'] }} x{{ $item['quantity'] }}</small>
                        <small>S/ {{ $item['price'] * $item['quantity'] }}</small>
                    </div>
                @endforeach

                <hr>

                <div class="d-flex justify-content-between">
                    <strong>Subtotal</strong>
                    <strong>S/ {{ number_format($subtotal,2) }}</strong>
                </div>

                <div class="d-flex justify-content-between">
                    <strong>Envío</strong>
                    <strong id="shipping-cost">S/ 0.00</strong>
                </div>

                <hr>

                <div class="d-flex justify-content-between fs-5">
                    <strong>Total</strong>
                    <strong id="order-total">
                        S/ {{ number_format($subtotal,2) }}
                    </strong>
                </div>

            </div>

        </div>

        </form>

    </div>

</div>

@include('componentes.footer')

@push('scripts')
<script>
document.querySelector("[name='department']")
.addEventListener("change", function(){

    let shipping = 0;

    if(this.value === "Lima"){
        shipping = 10;
    } else {
        shipping = 20;
    }

    document.getElementById("shipping-cost").innerText =
        "S/ " + shipping.toFixed(2);

    let subtotal = {{ $subtotal ?? 0 }};
    let total = subtotal + shipping;

    document.getElementById("order-total").innerText =
        "S/ " + total.toFixed(2);
});
</script>
@endpush

@endsection