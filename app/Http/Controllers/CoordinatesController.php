<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Coordinate;
use Carbon\Carbon;

class CoordinatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
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
        if (!$request["token"]) {
            return response()->json(['error' => 'missing token'], 401);
        }

        $user = User::where('api_token', $request["token"])->firstOrFail();

        $attributes = $request->validate([
            'lat' => 'required',
            'lng' => 'required',
        ]);

        $attributes["user_id"] = $user["id"];
        $attributes["created_at"] = date("Y-m-d H:i:s");
        $attributes["updated_at"] = date("Y-m-d H:i:s");

        Coordinate::create($attributes);

        return $attributes;
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

    public function userStartDates($id) {
        $endDate = Coordinate::select('created_at')->where('user_id', $id)->orderBy('created_at', 'desc')->first();

        return $endDate;
    }

}
