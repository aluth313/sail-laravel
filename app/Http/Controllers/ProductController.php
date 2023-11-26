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
                ->addColumn('purchase_price', function ($row) {
                    $purchase_price = number_format($row->purchase_price, 0, '.', ',');
                    return $purchase_price;
                })
                ->addColumn('selling_price', function ($row) {
                    $selling_price = number_format($row->selling_price, 0, '.', ',');
                    return $selling_price;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn =
                        '<a href="/products/'.$row->id.'/edit" class="btn btn-primary"><i class="fas fa-edit"></i></a> <button class="delete btn btn-danger" data-id="' .
                        $row->id .
                        '"><i class="fas fa-trash"></i></button> <a href="/products/add-stock/'.$row->id.'" class="btn btn-success"><i class="fas fa-plus"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['action','selling_price','purchase_price'])
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
        $data = $request->all();
        $data['selling_price'] = str_replace(',', '', $request->selling_price);
        $data['purchase_price'] = str_replace(',', '', $request->purchase_price);
        $data['profit'] = $data['selling_price'] - $data['purchase_price'];
        $product = Product::create($data);
        return redirect('products')->with('status','Berhasil menambah produk');
    }
    
    public function search(Request $request)
    {
        $products = Product::where('name', 'like', '%'.$request->input('query').'%')
        ->where('stock', '>', 0)
        ->limit(10)
        ->get();
        return $products;
    }

    /**
     * Display the specified resource.
     */
    public function addStock(string $id)
    {
        $product = Product::find($id);

        return view('products.add_stock', compact('product'));
    }
    
    public function updateStock(Request $request, string $id)
    {
        $product = Product::find($id);
        $product->stock += $request->stock;
        $product->save();

        return redirect('products')->with('status','Berhasil menambah stok');
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
        $product->purchase_price = str_replace(',', '', $request->purchase_price);
        $product->selling_price = str_replace(',', '', $request->selling_price);
        $product->profit = $product->selling_price - $product->purchase_price;
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
