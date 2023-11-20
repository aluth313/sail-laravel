<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Product::latest()->get();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn =
                        '<a href="/products/'.$row->id.'/edit" class="btn btn-primary"><i class="fas fa-edit"></i></a> <button class="delete btn btn-danger" data-id="' .
                        $row->id .
                        '"><i class="fas fa-trash"></i></button>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('products.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request['profit'] = $request->selling_price - $request->purchase_price;
        $product = Product::create($request->all());
        return redirect('products')->with('status','Berhasil menambah produk');
    }
    
    public function search(Request $request)
    {
        $products = Product::where('name', 'like', '%'.$request->input('query').'%')
        ->limit(10)
        ->get();
        return $products;
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
        $product = Product::find($id);

        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::find($id);
        $product->name = $request->name;
        $product->stock = $request->stock;
        $product->purchase_price = $request->purchase_price;
        $product->selling_price = $request->selling_price;
        $product->unit = $request->unit;
        $product->save();

        return redirect('products')->with('status','Berhasil mengupdate produk');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id)->delete();

        return redirect('products')->with('status','Berhasil menghapus produk');
    }
}
