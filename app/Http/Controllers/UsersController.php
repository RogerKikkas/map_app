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

        $app = app();
        $errors = $app->make('stdClass');

        if ($request{'currentPassword'}) {
            $hasher = app('hash');

            if (!$hasher->check($request['currentPassword'], $user->getAuthPassword())) {
                $errors->currentPassword = ['Current password doesn\'t match'];

                return response()->json([
                    'status' => 'error',
                    'errors' => $errors
                ], 422);
            }

            if ($request['currentPassword'] === $request['newPassword']) {
                $errors->newPassword = ['Current and new password cannot be the same'];

                return response()->json([
                    'status' => 'error',
                    'errors' => $errors
                ], 422);
            };

            $v = Validator::make($request->all(), [
                'newPassword' => 'required|min:3|confirmed'
            ]);

            if ($v->fails())
            {
                return response()->json([
                    'status' => 'error',
                    'errors' => $v->errors()
                ], 422);
            }

            $user->password = bcrypt($request['newPassword']);
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
