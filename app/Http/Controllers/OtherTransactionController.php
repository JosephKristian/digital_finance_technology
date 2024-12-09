<?php

namespace App\Http\Controllers;

use App\Models\OtherTransaction;
use App\Http\Requests\StoreOtherTransactionRequest;
use App\Http\Requests\UpdateOtherTransactionRequest;

class OtherTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('umkm.transaction.others.index');
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
    public function store(StoreOtherTransactionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(OtherTransaction $otherTransaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OtherTransaction $otherTransaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOtherTransactionRequest $request, OtherTransaction $otherTransaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OtherTransaction $otherTransaction)
    {
        //
    }
}
