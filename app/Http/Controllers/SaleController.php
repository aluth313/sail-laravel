<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SalesDetail;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $sale = Sale::create([
            'customer_id' => $request->customer_id,
            'user_id' => Auth::user()->id,
            'shipping_price' => str_replace(',', '', $request->shipping_price),
            'grand_total' => $request->grand_total,
        ]);
        
        $data = json_decode($request->selected_items);
        foreach ($data as $item) {
            $salesDetail = SalesDetail::create([
                'product_id' => $item->id,
                'sale_id' => $sale->id,
                'qty' => $item->qty,
                'selling_price' => $item->selling_price,
                'profit' => (($item->selling_price * $item->qty) - ($item->purchase_price * $item->qty)),
                'total' => $item->selling_price * $item->qty,
                'unit' => $item->unit,
            ]);
        }

        return redirect('home')->with('status','Berhasil memproses transaksi');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
