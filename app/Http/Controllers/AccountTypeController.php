<?php

namespace App\Http\Controllers;

use App\AccountType;
use Illuminate\Http\Request;

class AccountTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accountTypes = AccountType::all();
        return $this->successResponse($accountTypes);
    }

    /**
     * Show the form for creating a new resource.
     *AccountType
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
        $accountType = AccountType::create($campos);
        return $this->successResponse($accountType);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Joel\AccountType  $accountType
     * @return \Illuminate\Http\Response
     */
    public function show(AccountType $accountType)
    {
        return $this->successResponse($accountType);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Joel\AccountType  $accountType
     * @return \Illuminate\Http\Response
     */
    public function edit(AccountType $accountType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Joel\AccountType  $accountType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AccountType $accountType)
    {

        $accountType->fill($request->all());


        //dd($request);
        if ($accountType->isClean()) {
            return response()->json("No se hicieron cambios", 422);
        }

        $accountType->save();

        return $this->successResponse($accountType);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Joel\AccountType  $accountType
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccountType $accountType)
    {
        $accountType->delete();
        return $this->successResponse($accountType);
    }
}
