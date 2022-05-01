@extends('layouts.app')

@section('content')
<div class="container">

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 text-center">
                    @foreach ($invoiceTotales as $invtotal)
                        <h3>Facturas del cliente: {{$invtotal->cliente}} </h3>
                    @endforeach
                </div>
            </div>
            <div class="row" style="clear: both;margin-top: 18px;">
                <div class="col-12">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Impuesto %</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoiceDetails as $invdetail)
                            <tr>
                                <td>{{ $invdetail->id}}</td>
                                <td>{{ $invdetail->nombre }}</td>
                                <td>{{ $invdetail->precio }}</td>
                                <td>{{ $invdetail->impuesto }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                @foreach ($invoiceTotales as $invtotal)
                <div class="col-6 text-left">
                    <h5>Monto total: {{$invtotal->total}} </h5>
                </div>
                <div class="col-6 text-right">
                    <h5>Impuesto total: {{$invtotal->ImpuestoTotal}}%</h5>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

@endsection
