<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Sale;
use App\Models\SalesDetail;
use Illuminate\Http\Request;
use DataTables;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Customer::latest()->get();
        if ($request->ajax()) {
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $actionBtn =
                '<a href="/customers/'.$row->id.'/edit" class="btn btn-primary"><i class="fas fa-edit"></i></a> <button class="delete btn btn-danger" data-id="' .
                $row->id . 
                '"><i class="fas fa-trash"></i></button> <a href="/customers/history/'.$row->id.'" class="btn btn-success"><i class="fas fa-history"></i></a>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('customers.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $customer = Customer::create($request->all());
        return redirect('customers')->with('status','Berhasil menambah pelanggan');
    }

    public function history(Request $request, string $id)
    {
        $customer = Customer::find($id);
        $sales = Sale::with('salesDetail')->where('customer_id', $id)->orderByDesc('created_at')->get();

        if ($request->ajax()) {
            return DataTables::of($sales)
            ->addIndexColumn()
            ->addColumn('date', function ($row) {
                $transDate = formatDate($row->created_at, 'j F Y, H:i');
                return $transDate;
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
                '<a href="/customers/detail-history/'.$row->id.'" class="btn btn-primary"><i class="fas fa-search"></i></a>';
                return $actionBtn;
            })
            ->rawColumns(['action','date','amount','grand_total'])
            ->make(true);
        }
        
        return view('customers.history', compact('id','customer'));
    }

    public function detailHistory(string $id)
    {
        $details = Sale::with('salesDetail','customer','salesDetail.product')->find($id);

        return view('customers.detail_history', compact('details'));
    }
    
    public function edit(string $id)
    {
        $customer = Customer::find($id);

        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $customer = Customer::find($id);
        $customer->name = $request->name;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->save();

        return redirect('customers')->with('status','Berhasil mengupdate pelanggan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::find($id)->delete();

        return redirect('customers')->with('status','Berhasil menghapus pelanggan');
    }
}
