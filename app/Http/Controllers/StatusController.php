<?php

namespace App\Http\Controllers;

use App\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statuses = Status::all();
        return $this->successResponse($statuses);
    }

    /**
     * Show the form for creating a new resource.
     *Status
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
        $status = Status::create($campos);
        return $this->successResponse($status);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Joel\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function show(Status $status)
    {
        return $this->successResponse($status);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Joel\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function edit(Status $status)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Joel\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Status $status)
    {

        $status->fill($request->all());


        //dd($request);
        if ($status->isClean()) {
            return response()->json("No se hicieron cambios", 422);
        }

        $status->save();

        return $this->successResponse($status);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Joel\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function destroy(Status $status)
    {
        $status->delete();
        return $this->successResponse($status);
    }
}
