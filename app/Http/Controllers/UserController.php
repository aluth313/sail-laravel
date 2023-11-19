<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        
        return view('user.user', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect('account')->with('status','Berhasil mengubah akun');
    }
    
    public function updatePassword(Request $request, string $id)
    {
        $user = User::find($id);
        if (Auth::attempt(['email' => $user->email, 'password' => $request->current_password]) != 1) {
            return redirect('account')->with('error','Password Saat ini salah');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect('account')->with('status','Berhasil mengubah password');
    }
}
