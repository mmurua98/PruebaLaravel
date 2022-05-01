@extends('layouts.app')

@section('content')
<div class="container">
    
    <button type="button" id="generate" class="btn btn-info mb-1" >Generar facturas pendiente</button>
   
    
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 text-center">
                    <h3>Facturas</h3>
                </div>
            </div>
            <div class="row" style="clear: both;margin-top: 18px;">
                <div class="col-12">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Fecha</th>
                                <th>Total</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoices as $invoice)
                            <tr>
                                <td>{{ $invoice->id  }}</td>
                                <td>{{ $invoice->user->name}}</td>
                                <td>{{ $invoice->created_at }}</td>
                                <td>${{ $invoice->total }}</td>
                                <td>
                                    <a href="{{route('invoice.show', $invoice->id)}}" target="_blank" class="btn btn-info">Ver</a>
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

<script>
    document.addEventListener("DOMContentLoaded", function (event) {

        $(document).ready(function () {

            $('#generate').on('click', function () {
                //debugger;

                axios.post('/invoices/create')
                    .then(function (response) {
                        window.location.href = "/invoices/index";
                        console.log('funciona', response);
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
                    .then(function () {
                        // always executed
                    });
            })

        });
    });

</script>
@endsection
