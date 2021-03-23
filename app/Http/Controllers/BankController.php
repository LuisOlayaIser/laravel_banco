<?php

namespace App\Http\Controllers;

use App\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = Bank::all();
        return $this->successResponse($accounts);
    }

    /**
     * Show the form for creating a new resource.
     *Bank
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
        ];
        $this->validate($request, $rules);

        $campos = $request->all();

        //dd($campos);
        $bank = Bank::create($campos);
        return $this->successResponse($bank);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Joel\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function show(Bank $bank)
    {
        return $this->successResponse($bank);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Joel\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function edit(Bank $bank)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Joel\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bank $bank)
    {

        $bank->fill($request->all());


        //dd($request);
        if ($bank->isClean()) {
            return response()->json("No se hicieron cambios", 422);
        }

        $bank->save();

        return $this->successResponse($bank);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Joel\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bank $bank)
    {
        $bank->delete();
        return $this->successResponse($bank);
    }
}
