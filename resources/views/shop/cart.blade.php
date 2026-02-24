@extends('layouts.app')

@section('content')

@include('componentes.header')

<div class="container py-5">

    <h3 class="mb-4">Tu Carrito</h3>

    @if(count($cart) > 0)

        @php $total = 0; @endphp

        <div class="table-responsive">
            <table class="table align-middle">

                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                    </tr>
                </thead>

                <tbody id="cart-table-body">

                @foreach($cart as $id => $item)

                    @php
                        $lineTotal = $item['price'] * $item['quantity'];
                        $total += $lineTotal;
                    @endphp

                    <tr id="row-{{ $id }}">
                        <td>{{ $item['name'] }}</td>
                        <td>S/ {{ number_format($item['price'],2) }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>S/ {{ number_format($lineTotal,2) }}</td>
                        <td>
                            <button class="btn btn-sm btn-danger remove-item"
                                    data-id="{{ $id }}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>

                @endforeach

                </tbody>

            </table>
        </div>

        <button id="clear-cart"
                class="btn btn-danger mt-2">
            Vaciar carrito
        </button>

        <div class="text-end mt-4">
            <h4>Total: S/ <span id="cart-total">
                {{ number_format($total,2) }}
            </span></h4>

            <a href="{{ route('checkout.index') }}"
               class="btn btn-warning mt-3">
                Proceder al Checkout
            </a>
        </div>

    @else

        <div class="alert alert-info">
            Tu carrito está vacío.
        </div>

    @endif

</div>

@include('componentes.footer')

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function(){

    // ELIMINAR ITEM
    document.querySelectorAll(".remove-item").forEach(button => {
        button.addEventListener("click", function(){

            let id = this.dataset.id;

            fetch(`/cart/remove/${id}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                }
            })
            .then(res => res.json())
            .then(data => {

                if(data.success){

                    document.getElementById("row-"+id).remove();

                    updateBadge(data.cart_count);
                    recalculateTotal();

                }

            });

        });
    });

    // VACIAR CARRITO
    let clearBtn = document.getElementById("clear-cart");

    if(clearBtn){
        clearBtn.addEventListener("click", function(){

            fetch("{{ route('cart.clear') }}", {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                }
            })
            .then(res => res.json())
            .then(data => {

                if(data.success){
                    document.getElementById("cart-table-body").innerHTML =
                        `<tr><td colspan="5" class="text-center py-4">
                            Tu carrito está vacío
                         </td></tr>`;

                    document.getElementById("cart-total").innerText = "0.00";

                    updateBadge(0);
                }

            });

        });
    }

});

// Actualizar badge header
function updateBadge(count){
    let badge = document.getElementById("cart-count");
    if(badge){
        badge.innerText = count;
        badge.classList.add("bump");

        setTimeout(() => {
            badge.classList.remove("bump");
        }, 300);
    }
}

// Recalcular total dinámico
function recalculateTotal(){

    let rows = document.querySelectorAll("#cart-table-body tr");
    let total = 0;

    rows.forEach(row => {
        let cells = row.querySelectorAll("td");
        if(cells.length > 3){
            let value = cells[3].innerText
                .replace("S/","")
                .trim();

            total += parseFloat(value);
        }
    });

    document.getElementById("cart-total").innerText =
        total.toFixed(2);
}
</script>
@endpush

@endsection