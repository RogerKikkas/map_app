<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return response()->json(
            [
                'status' => 'success',
                'users' => $users->toArray()
            ], 200);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $user = User::findOrFail($id);

        return response()->json(
            [
                'status' => 'success',
                'user' => $user->toArray()
            ], 200);
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
        $user = Auth::user();
        $user->color = $request['color'] ?: $user->color;

        if ($request{'current_password'}) {
            $hasher = app('hash');

            if (!$hasher->check($request['current_password'], $user->getAuthPassword())) {
                return response()->json([
                    'status' => 'error',
                    'errors' => 'Current password doesn\'t match'
                ], 422);
            }

            if ($request['current_password'] === $request['new_password']) {
                return response()->json([
                    'status' => 'error',
                    'errors' => 'Current and new password cannot be the same'
                ], 422);
            };

            $v = Validator::make($request->all(), [
                'new_password' => 'required|min:3|confirmed'
            ]);

            if ($v->fails())
            {
                return response()->json([
                    'status' => 'error',
                    'errors' => $v->errors()->all()[0]
                ], 422);
            }

            $user->password = bcrypt($request['new_password']);
        }

        $user->save();

        return response()->json(
            [
                'status' => 'success',
                'user' => $user
            ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'errors' => 'User with id ' . $id . ' does not exist'
            ], 404);
        }

        $user->delete();

        return response()->json(
            [
                'status' => 'success',
            ], 200);
    }

    public function usersForMap() {
        $users = User::select('id', 'name', 'color')->get();

        return $users;
    }
}
