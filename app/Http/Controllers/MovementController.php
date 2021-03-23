<?php

namespace App\Http\Controllers;

use App\Account;
use App\Movement;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MovementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movements = Movement::all();
        return $this->successResponse($movements);
    }

    /**
     * Show the form for creating a new resource.
     *Movement
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
            'amount' => 'required',
            'coin' => 'required',
            'description' => 'required',
            'origin_id' => 'required',
            'destination_id' => 'required',
        ];
        $this->validate($request, $rules);
        
        $origin = Account::findOrFail($request->origin_id);
        if ($origin->balance < $request->amunt) {
            return $this->errorResponse('El monto es insuficiente', 422);
        }
        

        $campos = $request->except(['origin_id', 'destination_id']);
        $campos['transaction'] = $request->origin_id.$request->destination_id.Carbon::now()->timestamp;
        $campos['date'] = Carbon::now();
        $campos['status_id'] = 3;
        //dd($campos);
        $movement = Movement::create($campos);
        $origindata['type'] = 'origin';
        $destinationdata['type'] = 'destination';
        $movement->accounts()->attach($request->origin_id, $origindata);
        $movement->accounts()->attach($request->destination_id, $destinationdata);

        $destination = Account::findOrFail($request->destination_id);
        $camposO['balance'] = $origin->balance - $request->amount;
        $camposD['balance'] = $destination->balance + $request->amount;
        $origin->fill($camposO);
        $origin->save();
        $destination->fill($camposD);
        $destination->save();

        $campos['status_id'] = 1;
        $movement->fill($campos);
        $movement->save();
        $movement['accounts'] = $movement->accounts;
        return $this->successResponse($movement);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Joel\Movement  $movement
     * @return \Illuminate\Http\Response
     */
    public function show(Movement $movement)
    {
        return $this->successResponse($movement);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Joel\Movement  $movement
     * @return \Illuminate\Http\Response
     */
    public function edit(Movement $movement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Joel\Movement  $movement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Movement $movement)
    {

        $movement->fill($request->all());


        //dd($request);
        if ($movement->isClean()) {
            return response()->json("No se hicieron cambios", 422);
        }

        $movement->save();

        return $this->successResponse($movement);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Joel\Movement  $movement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movement $movement)
    {
        $movement->delete();
        return $this->successResponse($movement);
    }
}
