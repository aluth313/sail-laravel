<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SalesDetail;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use DataTables;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function perMonth()
    {
        return view('reports.month');
    }
    
    public function perDay()
    {
        return view('reports.day');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getDataPerMonth(Request $request)
    {
        
        $data = [];
        if ($request->dateFrom != '' && $request->dateTo != '') {
            $year = date('Y');
            $sales = Sale::with('salesDetail')
                ->whereYear('created_at', '=', $year)
                ->whereMonth('created_at', '>=', $request->dateFrom)
                ->whereMonth('created_at', '<=', $request->dateTo)
                ->orderBy('created_at')
                ->get();

            $months = [];
            $salePerMonth = [];
            $profits = [];
            foreach ($sales as $sale) {
                if (!in_array(formatDate($sale->created_at, 'F Y'), $months)) {
                    array_push($months, formatDate($sale->created_at, 'F Y'));
                    array_push($salePerMonth, $sale->grand_total);
                    $profit = 0;
                    foreach ($sale->salesDetail as $detail) {
                        $profit += $detail->profit;
                    }
                    array_push($profits, $profit);
                } else {
                    $index = count($salePerMonth);
                    $salePerMonth[$index - 1] += $sale->grand_total;
                    foreach ($sale->salesDetail as $detail) {
                        $profits[$index - 1] += $detail->profit;
                    }
                }
            }

            for ($i=0; $i < count($months); $i++) { 
                array_push($data, [
                    'month' => $months[$i],
                    'sale' => $salePerMonth[$i],
                    'profit' => $profits[$i],
                ]);
            }
        }
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('sale', function ($row) {
                    return number_format($row['sale'], 0, '.', ',');
                })
                ->addColumn('profit', function ($row) {
                    return number_format($row['profit'], 0, '.', ',');
                })
                ->rawColumns(['sale','profit'])
                ->make(true);
        }
    }
    
    public function getDataPerDay(Request $request)
    {
        
        $data = [];
        if ($request->dateFrom != '' && $request->dateTo != '') {
            $sales = Sale::with('salesDetail')
                ->whereBetween('created_at', [$request->dateFrom.' 00:00:01', $request->dateTo.' 23:59:59'])
                ->orderBy('created_at')
                ->get();

            $days = [];
            $salePerDay = [];
            $profits = [];
            foreach ($sales as $sale) {
                if (!in_array(formatDate($sale->created_at, 'j F Y'), $days)) {
                    array_push($days, formatDate($sale->created_at, 'j F Y'));
                    array_push($salePerDay, $sale->grand_total);
                    $profit = 0;
                    foreach ($sale->salesDetail as $detail) {
                        $profit += $detail->profit;
                    }
                    array_push($profits, $profit);
                } else {
                    $index = count($salePerDay);
                    $salePerDay[$index - 1] += $sale->grand_total;
                    foreach ($sale->salesDetail as $detail) {
                        $profits[$index - 1] += $detail->profit;
                    }
                }
            }

            for ($i=0; $i < count($days); $i++) { 
                array_push($data, [
                    'day' => $days[$i],
                    'sale' => $salePerDay[$i],
                    'profit' => $profits[$i],
                ]);
            }
        }
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('sale', function ($row) {
                    return number_format($row['sale'], 0, '.', ',');
                })
                ->addColumn('profit', function ($row) {
                    return number_format($row['profit'], 0, '.', ',');
                })
                ->rawColumns(['sale','profit'])
                ->make(true);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $sale = Sale::create([
            'customer_id' => $request->customer_id,
            'user_id' => Auth::user()->id,
            'shipping_price' => $request->shipping_price == null || $request->shipping_price == '' || $request->shipping_price == 0 ? null : str_replace(',', '', $request->shipping_price),
            'grand_total' => $request->grand_total,
        ]);

        $data = json_decode($request->selected_items);
        foreach ($data as $item) {
            $salesDetail = SalesDetail::create([
                'product_id' => $item->id,
                'sale_id' => $sale->id,
                'qty' => $item->qty,
                'selling_price' => $item->selling_price,
                'profit' => $item->selling_price * $item->qty - $item->purchase_price * $item->qty,
                'total' => $item->selling_price * $item->qty,
                'unit' => $item->unit,
            ]);

            $product = Product::find($item->id);
            $product->stock = $product->stock - $item->qty;
            $product->save();
        }

        return redirect('home')->with('status', 'Berhasil memproses transaksi');
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
