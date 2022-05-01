<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\InvoiceDetails;
use App\Order;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::all();
        return view('invoices/index', compact('invoices'));
    }

    public function store(Request $request)
    {
        //Obtener usuarios tipo CUSTOMER
        $users = User::where('role', 2)->get();

        $products = Product::all();

        foreach ($users as $user) 
        {
            //Productos no facturados por usuario
            $no_facturado = Order::where(['facturado' => 'no',  'user_id' => $user->id])->get();

            if(count($no_facturado) > 0)
            {
                $invoice = new Invoice();
                $invoice->user_id = $user->id;
                $invoice->total = collect($no_facturado)->sum('total');//obtener suma de todos las ordenes pendientes
                $invoice->save();
                
                if($invoice->id > 0)
                {   
                    foreach ($no_facturado as $order)
                    {
                        $current_product = $products->firstWhere('id', $order->product_id);

                        $invoiceDetail = new InvoiceDetails();
                        $invoiceDetail->invoice_id =  $invoice->id;
                        $invoiceDetail->order_id =  $order->id;
                        $invoiceDetail->product_id =  $order->product_id;
                        $invoiceDetail->precio =  $current_product->precio;
                        $invoiceDetail->impuesto =  $current_product->impuesto;
                        $invoiceDetail->producto_total =  $order->total;

                        $invoiceDetail->save();

                        if($invoiceDetail->id > 0)
                        {
                            $order->facturado = 'si';
                            $order->save();
                        }
                    }
                }
            }
            
        }

        
        
    }

    public function show($id)
    {
        $invoiceDetails = DB::table('invoice_details')
            ->join('invoices', 'invoice_details.invoice_id','invoices.id')
            ->join('products', 'invoice_details.product_id','products.id')
            ->join('orders', 'invoice_details.order_id','orders.id')
            ->select('invoices.id','products.nombre', 'invoice_details.precio', 'invoice_details.impuesto', 'invoice_details.producto_total', 'orders.created_at')
            ->where('invoices.id', '=', $id)
            ->orderBy('orders.id', 'ASC')
            ->get();

        $invoiceTotales = DB::table('invoice_details')
        ->join('invoices', 'invoice_details.invoice_id','invoices.id')
        ->join('users', 'invoices.user_id','users.id')
        ->select('invoice_details.invoice_id','users.name AS cliente','invoices.total',
                DB::raw('SUM(invoice_details.impuesto) AS ImpuestoTotal') )
        ->where('invoice_details.invoice_id', '=', $id)
        ->get();

        return view('invoices.invoice', compact('invoiceDetails', 'invoiceTotales'));

      
    }
}