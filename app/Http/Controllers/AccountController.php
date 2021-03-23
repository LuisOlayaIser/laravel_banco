<?php

namespace App\Http\Controllers;

use App\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        if ($user->type == 1) {
            $accounts = $user->accounts()->with('bank')->with('account_type')->get();
        } else {
            $accounts = Account::with('bank')->with('accountType')->get();
        }
        return $this->successResponse($accounts);
    }

    /**
     * Show the form for creating a new resource.
     *Account
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
            'alias' => 'required',
            'bank_id' => 'required',
            'account_type_id' => 'required',
        ];
        $this->validate($request, $rules);

        $user = $request->user();

        $campos = $request->all();
        $campos['user_id'] = $user->id;
        do {
            $number = $this->generateString();
            $accounts = Account::where('number', '=', $number)->get();
        } while (sizeof($accounts) > 0);
        $campos['number'] = $number;

        //dd($campos);
        $account = Account::create($campos);
        return $this->successResponse($account);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Joel\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function show(Account $account, Request $request)
    {
        $user = $request->user();
        if ($user->id != $account->user_id) {
            return $this->errorResponse('No tienes pemisos para realizar esta consulta', 422);
        }
        $account->movements = $account->movements;
        $account->bank = $account->bank;
        $account->account_type = $account->account_type;
        return $this->successResponse($account);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Joel\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function edit(Account $account)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Joel\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Account $account)
    {

        $account->fill($request->all());


        //dd($request);
        if ($account->isClean()) {
            return response()->json("No se hicieron cambios", 422);
        }

        $account->save();

        return $this->successResponse($account);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Joel\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account)
    {
        $account->delete();
        return $this->successResponse($account);
    }
}
