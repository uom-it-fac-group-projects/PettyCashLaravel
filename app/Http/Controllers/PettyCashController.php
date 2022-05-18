<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PettyCash;
use App\Models\Imprest;


class PettyCashController extends Controller
{
    public function index()
    {
        $pettycash = PettyCash::orderBy('date', 'ASC')->get();
        $amountTotal = $pettycash->sum('amount');
        $stationaryTotal = PettyCash::where('type', 'stationary')->sum('amount');
        $travellingTotal = PettyCash::where('type', 'travelling')->sum('amount');
        $postageTotal = PettyCash::where('type', 'postage')->sum('amount');
        $othersTotal = PettyCash::where('type', 'others')->sum('amount');

        $imprest = Imprest::select('imprest_amount')->first();

        if($imprest == null) {
            $imprest_amount = null;
        }
        else {
            $imprest_amount = $imprest['imprest_amount'];
        }
        
        
        // if($imprest.isEmpty()) {
        //     $imprest_amount = null;
        // } else {
        //     $imprest_amount = $imprest->imprest_amount;
        // }

        return view('home',compact('pettycash', 'amountTotal', 'stationaryTotal', 'travellingTotal', 'postageTotal', 'othersTotal', 'imprest_amount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'description' => 'required| max:20',
            'voucher_number' => 'required| max:10',
            'amount' => 'required',
            'type' => 'required',
        ]);
        $input = $request->all();
        $totalAmount = PettyCash::sum('amount');
        $imprest_amount = 50000;

        $estimated_total =  $totalAmount + $request->amount;

        if($estimated_total <= $imprest_amount) {
            PettyCash::create($input);
            return redirect('/')->with('status', 'Transaction added successfully');
        } else {
            return redirect('/')->with('error', 'Total amount should not exceed the imprest amount');
        }

    }

    public function delete($id)
    {
        $transaction = PettyCash::find($id);
        $transaction->delete();

        return redirect('/')->with('error', 'Record has been deleted');
    }

    public function deleteDB()
    {
        PettyCash::truncate();
        Imprest::truncate();

        return redirect('/')->with('error', 'Data has been reset');
    }
}
