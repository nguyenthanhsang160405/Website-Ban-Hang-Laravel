<?php

namespace App\Http\Controllers;

use App\Models\DetaiOrder;
use Illuminate\Http\Request;

class DetaiOrderController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DetaiOrder $detaiOrder)
    {
        //
        
    }

    public function goComment($id)
    {
        //
        $detail = DetaiOrder::find($id);
        return redirect('/product/'.$detail->product_id)->with('id_detail_order',$detail->id);
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DetaiOrder $detaiOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DetaiOrder $detaiOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DetaiOrder $detaiOrder)
    {
        //
    }
}
