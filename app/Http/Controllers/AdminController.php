<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function changeSecretCode(Request $request) {

        $validated = $request->validate([
            'secret_code' => 'required|min:3'
        ]);

        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);
        $oldValue = env("SECRET_CODE");
        $newValue = $validated['secret_code'];
        $str = str_replace("SECRET_CODE={$oldValue}", "SECRET_CODE={$newValue}", $str);
        $fp = fopen($envFile, 'w');
        fwrite($fp, $str);
        fclose($fp);

        return response()->json(
            [
                'status' => 'success',
            ], 200);
    }
}
