<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\supplier;

class suppliercontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // mengambil data dari database melalui model product,
        //fungsi all() sama seperti SELECT * FROM

        $data = Supplier::all();
        return view("master-data.supplier-master.index-supplier", compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("master-data.supplier-master.create-supplier");
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
            'supplier_name' => 'required|string|max:50',
            'supplier_address' => 'required|string|max:50',
            'phone' => 'nullable|string',
            'comment' => 'required|string',
        ]);

        // progres simpan data kedalam database
        supplier::create($validasi_data);

        return redirect()->back()->with('success', 'supplier created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
