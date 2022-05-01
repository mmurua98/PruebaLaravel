@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="row" style="clear: both;margin-top: 18px;">
                <div class="col-12">
                    <div class="form-group">
                        <label for="product_id">Producto:</label>
                        <select class="form-control" name="product_id" id="product_id">
                            <option value="" disabled selected>-- Seleccione un Producto--</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" 
                                    data-precio={{$product->precio}} 
                                    data-impuesto={{$product->impuesto}}> {{ $product->nombre}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label for="precio">Precio</label>
                        <input type="text" class="form-control" id="precio" name="precio" readonly>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="impuesto">Impuesto %</label>
                        <input type="text" class="form-control" id="impuesto" name="impuesto" readonly>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="total">Total</label>
                        <input type="text" class="form-control" id="total" name="total" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-right">
                    <button type="button" class="btn btn-success" onclick="createOrder()"> Comprar </button>
                </div>
            </div>
        </div>
    </div>

</div>


<script>
    document.addEventListener('DOMContentLoaded', () => {
        $('#product_id').on('change',function(){
        var precio = $(this).children('option:selected').data('precio');
        var impuesto = $(this).children('option:selected').data('impuesto');
        var total = parseFloat(precio, 10) + (parseFloat(impuesto, 10) / 100 * parseFloat(precio, 10) );
        $('#precio').val(precio);
        $('#impuesto').val(impuesto);
        $('#total').val(total);
    });
    });
    

    function createOrder() {
        var product_id = $('#product_id').val();
        var precio = $('#precio').val();
        var impuesto = $('#impuesto').val();
        var total = $('#total').val();

        let _url = `/orders/create`;
        let _token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: _url,
            type: "POST",
            data: {
                product_id: product_id,
                precio: precio,
                impuesto: impuesto,
                total: total,
                _token: _token
            },
            success: function (data) {
                console.log(data);

                alert('Producto comprado!')

                $('#product_id').val('');
                $('#precio').val('');
                $('#impuesto').val('');
                $('#total').val('');

            },
            error: function (response) {
                $('#taskError').text(response.responseJSON.errors.product);
            }
        });
    }

</script>
@endsection
