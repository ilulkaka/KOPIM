<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Models\User;
use Session;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::check()) {
            return redirect('home');
        } else {
            return view('login');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        //return response()->json([
        //    'data' => $user,
        //    'access_token' => $token,
        //    'token_type' => 'Bearer',
        //]);
        return redirect('home');
    }

    public function loginaksi(Request $request)
    {
        // dd($request->all());
        $email = User::select('status', 'email', 'role')
            ->where('email', $request->email)
            ->get();

        if ($email->isEmpty()) {
            Session::flash('error', 'Akun tidak terdaftar .');
            return redirect('/');
        }

        if ($email[0]->status == 'Non Aktif') {
            Session::flash('error', 'Akun sudah tidak Aktif .');
            return redirect('/');
        }
        if (!Auth::attempt($request->only('email', 'password'))) {
            Session::flash('error', 'Email atau Password Salah');
            return redirect('/');
            //return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();
        // $userToken = auth()->user();

        auth()
            ->user()
            ->tokens()
            ->delete();

        $token = $user->createToken($user->name)->plainTextToken;

        if ($email[0]->role == 'Kasir') {
            return redirect()->route('transaksi');
        } else {
            return redirect('home');
        }
        /*return response()->json([
            'message' => 'Hi ' . $user->name . ', welcome to home',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);*/
    }

    public function logoutaksi()
    {
        //return redirect('/');
        auth()
            ->user()
            ->tokens()
            ->delete();
        Auth::logout();
        return redirect('/');
        //return [
        //  'message' =>
        //    'You have successfully logged out and the token was successfully deleted',
        //];
    }
}
