<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AdminController extends Controller
{
    public function changeSecretCode(Request $request) {

        $validated = $request->validate([
            'secretCode' => 'required|min:3'
        ]);

        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);
        $oldValue = env("SECRET_CODE");
        $newValue = $validated['secretCode'];
        $str = str_replace("SECRET_CODE={$oldValue}", "SECRET_CODE={$newValue}", $str);
        $fp = fopen($envFile, 'w');
        fwrite($fp, $str);
        fclose($fp);

        return response()->json(
            [
                'status' => 'success',
            ], 200);
    }

    public function changeUserPassword(Request $request) {

        $validated = $request->validate([
            'userId' => 'required',
            'newPassword' => 'required|min:3|confirmed'
        ]);

        $user = User::find($validated['userId']);

        $app = app();
        $errors = $app->make('stdClass');

        if ($user) {
            $user->password = bcrypt($request['newPassword']);

            $user->save();

            return response()->json(
                [
                    'status' => 'success',
                    'user' => $user
                ], 200);
        } else {
            $errors->userNotFound = ['User not found'];

            return response()->json([
                'status' => 'error',
                'errors' =>  $errors
            ], 422);
        }
    }
}
