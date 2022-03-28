<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\CustomerTransaction;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['verified', 'auth']);
    }

    public function index()
    {
        // $data = CustomerTransaction::selectRaw('sum(amount) as amount, MONTH(date_created) as month, YEAR(date_created) as year')
        // ->join('customers', 'transactions.customer_id', '=', 'customers.id')
        // ->groupBy('customer_id', 'month', 'year')
        // ->get();

        $data = Customer::with('transactions')->get();

        // $data = Customer::with([
        //     'transactions' => function ($query) {
        //         $query->selectRaw('sum(amount) as amount, MONTH(date_created) as month, YEAR(date_created) as year');
        //     }
        // ])
        // ->groupBy('customer_id', 'month', 'year')
        // ->get();


        // dd($data);

        return view('home', compact('data'));
    }
}
