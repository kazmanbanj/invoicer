<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\Customer;
use App\Models\InvoicesItem;
use Illuminate\Http\Request;
use App\Models\CustomersField;
use Mpociot\VatCalculator\Facades\VatCalculator;

class InvoiceController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::with('customer')
            ->when(request('query'), function($query) {
                return $query
                ->where('invoice_number', 'like', '%'.request('query').'%')
                ->orWhere('invoice_date', 'like', '%'.request('query').'%');
            })->get();
        return view('home', compact('invoices'));
    }

    public function create(Request $request)
    {
        $customer = Customer::find($request->customer_id);
        $tax = VatCalculator::getTaxRateForLocation($customer->country->shortcode) * 100;
        $products = Product::all();
        return view('invoices.create', compact('tax', 'products', 'customer'));
    }

    public function store(Request $request)
    {
        $invoice = Invoice::create($request->invoice + ['user_id' => auth()->id()]);

        if ($request->product == '' || $request->product == null) {
            return view('products.create');
        } else {
            for ($i=0; $i < count($request->product); $i++) {
                if (isset($request->qty[$i]) && isset($request->price[$i])) {
                    InvoicesItem::create([
                        'invoice_id' => $invoice->id,
                        'name' => $request->product[$i],
                        'quantity' => $request->qty[$i],
                        'price' => $request->price[$i]
                    ]);
                }
            }
        }

        return redirect()->route('home');
    }

    public function show($invoice_id)
    {
        $invoice = Invoice::findOrFail($invoice_id);
        return view('invoices.show', compact('invoice'));
    }

    public function download($invoice_id)
    {
        $invoice = Invoice::findOrFail($invoice_id);
        $pdf = \PDF::loadView('invoices.pdf', compact('invoice'));
        set_time_limit(250);
        return $pdf->stream('invoice.pdf');
    }
}
