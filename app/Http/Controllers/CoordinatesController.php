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
            'lon' => 'required',
        ]);

        $attributes["user_id"] = $user["id"];
        $attributes["speed"] = $request["spd"] ?: '0';
        $attributes["altitude"] = $request["alt"] ?: '0';
        $attributes["travelled"] = $request["dist"] ?: '0';

        if ($request['time']) {
            $attributes["created_at"] = date('Y-m-d H:i:s', strtotime($request['time']));
            $attributes["updated_at"] = date('Y-m-d H:i:s', strtotime($request['time']));
        } else {
            $attributes["created_at"] = date("Y-m-d H:i:s");
            $attributes["updated_at"] = date("Y-m-d H:i:s");
        }

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

    public function userCoordinates($id, Request $request){

        if (!$id) {
            return response()->json(['error' => 'No id']);
        }

        // Get start and end date from request
        $startDate = $request->startDate;
        $endDate = $request->endDate;

        // Remove double quotes from start and end date
        $startDate = trim($startDate, '""');
        $endDate = trim($endDate, '""');

        // Create a new Carbon object with start and end dates and then reformat them to be usable by Eloquent
        $startDate = (new Carbon($startDate))->setTime(0, 0, 0)->format('Y-m-d:H:i:s');
        $endDate = (new Carbon($endDate))->setTime(23, 59, 59)->format('Y-m-d:H:i:s');

        $coordinates = Coordinate::select('id', 'user_id', 'lat', 'lon', 'speed', 'altitude', 'travelled', 'created_at')->where('user_id', $id)->whereBetween('created_at', [$startDate, $endDate])->get();

        return $coordinates;
    }

}
