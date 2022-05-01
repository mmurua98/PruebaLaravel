@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="row">
            <div class="col-12 text-right">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addProductModal">Add Todo</button>
            </div>
            </div>
            <div class="row" style="clear: both;margin-top: 18px;">
                <div class="col-12">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Impuesto</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr id="product_{{$product->id}}">
                            <td>{{ $product->id  }}</td>
                            <td>{{ $product->nombre }}</td>
                            <td>{{ $product->precio }}</td>
                            <td>{{ $product->impuesto }}</td>
                            <td>
                                <a data-id="{{ $product->id }}" onclick="editProduct(event.target)" class="btn btn-info">Edit</a>
                                <a class="btn btn-danger" onclick="deleteProduct({{ $product->id }})">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            </div>
        </div>
    </div>
    
</div>
<div class="modal fade" id="addProductModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Add Todo</h4>
        </div>
        <div class="modal-body">

                <div class="form-group">
                    <label for="name" class="col-sm-2">Nombre</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="nombre" name="nombre">
                        <span id="taskError" class="alert-message"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-2">Precio</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="precio" name="precio">
                        <span id="taskError" class="alert-message"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-2">Impuesto %</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="impuesto" name="impuesto">
                        <span id="taskError" class="alert-message"></span>
                    </div>
                </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="addProduct()">Save</button>
        </div>
    </div>
  </div>
  
</div>
<div class="modal fade" id="editProductModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Editar Producto</h4>
        </div>
        <div class="modal-body">

               <input type="hidden" name="producto_id" id="producto_id">
                <div class="form-group">
                    <label for="name" class="col-sm-2">Nombre</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="editnombre" name="nombre">
                        <span id="taskError" class="alert-message"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-2">Precio</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="editprecio" name="precio">
                        <span id="taskError" class="alert-message"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-2">Impuesto</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="editimpuesto" name="impuesto">
                        <span id="taskError" class="alert-message"></span>
                    </div>
                </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="updateProduct()">Save</button>
        </div>
    </div>
  </div>
<script>

    function addProduct() {
        var nombre = $('#nombre').val();
        var precio = $('#precio').val();
        var impuesto = $('#impuesto').val();

        let _url     = `/products/create`;
        let _token   = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: _url,
            type: "POST",
            data: {
                nombre: nombre,
                precio: precio,
                impuesto: impuesto,
                _token: _token
            },
            success: function(data) {
                    product = data
                    $('table tbody').append(`
                        <tr id="product_${product.id}">
                            <td>${product.id}</td>
                            <td>${ product.nombre }</td>
                            <td>${ product.precio }</td>
                            <td>${ product.impuesto }</td>
                            <td>
                                <a data-id="${ product.id }" onclick="editProduct(${product.id})" class="btn btn-info">Edit</a>
                                <a data-id="${product.id}" class="btn btn-danger" onclick="deleteProduct(${product.id})">Delete</a>
                            </td>
                        </tr>
                    `);

                    $('#nombre').val('');
                    $('#precio').val('');
                    $('#impuesto').val('');

                    $('#addProductModal').modal('hide');
            },
            error: function(response) {
                $('#taskError').text(response.responseJSON.errors.product);
            }
        });
    }

    function deleteProduct(id) {
        let url = `/products/${id}`;
        let token   = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: url,
            type: 'DELETE',
            data: {
            _token: token
            },
            success: function(response) {
                $("#product_"+id).remove();
            }
        });
    }

    function editProduct(e) {
        var id  = $(e).data("id");
        var nombre  = $("#product_"+id+" td:nth-child(2)").html();
        var precio  = $("#product_"+id+" td:nth-child(3)").html();
        var impuesto  = $("#product_"+id+" td:nth-child(4)").html();
        $("#producto_id").val(id);
        $("#editnombre").val(nombre);
        $("#editprecio").val(precio);
        $("#editimpuesto").val(impuesto);
        $('#editProductModal').modal('show');
    }

    function updateProduct() {
        var nombre = $('#editnombre').val();
        var precio = $('#editprecio').val();
        var impuesto = $('#editimpuesto').val();
        var id = $('#producto_id').val();
        let _url     = `/products/update/${id}`;
        let _token   = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: _url,
            type: "PUT",
            data: {
                nombre: nombre,
                precio: precio,
                impuesto: impuesto,
                _token: _token
            },
            success: function(data) {
                    product = data
                    $("#product_"+id+" td:nth-child(2)").html(product.nombre);
                    $("#product_"+id+" td:nth-child(3)").html(product.precio);
                    $("#product_"+id+" td:nth-child(4)").html(product.impuesto);

                    $('#producto_id').val('');
                    $('#editnombre').val('');
                    $('#editprecio').val('');
                    $('#editimpuesto').val('');
                    $('#editProductModal').modal('hide');
            },
            error: function(response) {
                $('#taskError').text(response.responseJSON.errors);
            }
        });
    }

</script>
@endsection