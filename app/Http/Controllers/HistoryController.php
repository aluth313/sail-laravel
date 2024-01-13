<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SalesDetail;
use Illuminate\Http\Request;
use DataTables;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sales = Sale::with('salesDetail','customer')->orderByDesc('created_at')->get();

        if ($request->ajax()) {
            return DataTables::of($sales)
            ->addIndexColumn()
            ->addColumn('date', function ($row) {
                $transDate = formatDate($row->created_at, 'j F Y, H:i');
                return $transDate;
            })
            ->addColumn('customer', function ($row) {
                $customer = $row->customer->name ?? '-';
                return $customer;
            })
            ->addColumn('amount', function ($row) {
                $amount = count($row->salesDetail);
                return $amount;
            })
            ->addColumn('grand_total', function ($row) {
                $total = number_format($row->grand_total, 0, '.', ',');
                return $total;
            })
            ->addColumn('action', function ($row) {
                $actionBtn =
                '<a href="/histories/'.$row->id.'" class="btn btn-primary"><i class="fas fa-search"></i></a>';
                return $actionBtn;
            })
            ->rawColumns(['action','date','amount','grand_total'])
            ->make(true);
        }
        
        return view('histories.history');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $details = Sale::with('salesDetail','customer','salesDetail.product')->find($id);

        return view('histories.detail_history', compact('details'));
    }
}
