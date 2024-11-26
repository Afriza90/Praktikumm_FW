<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\supplier;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
{
    // Membuat query builder baru untuk model Product
    $query = Product::with('supplier');

    // Cek apakah ada parameter 'search' di request
    if ($request->has('search') && $request->search != '') {
        // Melakukan pencarian berdasarkan nama produk atau informasi
        $search = $request->search;
        $query->where('product_name', 'like', '%' . $search . '%');
    }

    // Gunakan query builder untuk paginasi
    $products = $query->paginate(10);
    //return $products;
    return view("master-data.product-master.index-product", compact('products'));
}


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $suppliers = Supplier::all();
        return view("master-data.product-master.create-product", compact
        ('suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validasi input data
        $validasi_data = $request->validate([
            'product_name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'type' => 'required|string|max:50',
            'information' => 'nullable|string',
            'qty' => 'required|integer',
            'producer' => 'required|string|max:255',
            'supplier_Id'=>'required|exists:suppliers,id',
        ]);

        // progres simpan data kedalam database
        Product::create($validasi_data);

        return redirect()->back()->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Ada 2 cara menampilkan detail product
        // pakai find atau findOrFail
        $product = Product::findOrFail(id: $id);
        return view("master-data.product-master.detail-product", compact('products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $suppliers = Supplier::all();
        return view('master-data.product-master.edit-product', compact('product', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
{
    $request->validate([
        'product_name' => 'required|string|max:255',
        'unit' => 'required|string|max:255',
        'type' => 'required|string|max:255',
        'information' => 'nullable|string',
        'qty' => 'required|integer|min:1',
        'producer' => 'required|string|max:255',
        'supplier_id' => 'required|exists:suppliers,id', // Validasi supplier_id
    ]);

    $product = Product::findOrFail($id);

    $product->update([
        'product_name' => $request->product_name,
        'unit' => $request->unit,
        'type' => $request->type,
        'information' => $request->information,
        'qty' => $request->qty,
        'producer' => $request->producer,
        'supplier_id' => $request->supplier_id,
    ]);
        return redirect()->back()->with('success', 'Product update successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if($product) {
            $product->delete();
            return redirect()->route('product')->with('succes', 'product berhasil dihapus.');
        }
        return redirect()->route('product')->with('error', 'product tidak ditemukan');
    }

    public function exportExcel(){
        return Excel::download(new ProductsExport, 'product.xlsx');
    }

    public function exportPDF()
    {
    $ss = Product::all();
    $pdf = Pdf::loadView('Exports.product-pdf', compact('products'));
    $pdf->setPaper('A4', 'portrait');
    return $pdf->download('product.pdf');
    }
}