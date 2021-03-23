<?php

namespace App\Http\Controllers;

use App\Account;
use App\Inscription;
use Illuminate\Http\Request;

class InscriptionController extends Controller
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
            $inscriptions = $user->inscriptions()->with('account')->get();
        } else {
            $inscriptions = Inscription::with('account')->get();
        }
        return $this->successResponse($inscriptions);
    }

    /**
     * Show the form for creating a new resource.
     *Inscription
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
            'number' => 'required',
            'cc' => 'required',
            'type_account' => 'required',
            'bank' => 'required',
        ];
        $this->validate($request, $rules);
        $user = $request->user();
        $campos = $request->only(['alias']);
        $campos['user_id'] = $user->id;
        $accountExist = $user->inscriptions()->whereHas('account', function($query) use($request, $user) {
            $query->where('number', $request->number);
        })
        ->with('account')->get();
        if(sizeof($accountExist)>0) {
            return $this->errorResponse('Esta cuenta ya esta inscrita con el alias \''.$accountExist[0]->alias.'\'', 422);
        }
        
        $account =  Account::where('number', $request->number)
            ->whereHas('user', function($query) use($request, $user) {
                $query->where('identification_card', $request->cc)->where('id', '!=',$user->id);
            })
            ->whereHas('bank', function($query) use($request) {
                $query->where('id', $request->bank);
            })
            ->whereHas('account_type', function($query) use($request) {
                $query->where('id', $request->type_account);
            })
            ->get();
            if(sizeof($account)==0) {
                return $this->errorResponse('Estos datos no tienen coincidencia', 422);
            }
        $campos['account_id'] = $account[0]->id;
        //dd($campos);
        $inscription = Inscription::create($campos);
        return $this->successResponse($inscription);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Joel\Inscription  $inscription
     * @return \Illuminate\Http\Response
     */
    public function show(Inscription $inscription)
    {
        return $this->successResponse($inscription);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Joel\Inscription  $inscription
     * @return \Illuminate\Http\Response
     */
    public function edit(Inscription $inscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Joel\Inscription  $inscription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inscription $inscription)
    {

        $inscription->fill($request->all());


        //dd($request);
        if ($inscription->isClean()) {
            return response()->json("No se hicieron cambios", 422);
        }

        $inscription->save();

        return $this->successResponse($inscription);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Joel\Inscription  $inscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inscription $inscription)
    {
        $inscription->delete();
        return $this->successResponse($inscription);
    }
}
