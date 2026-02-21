<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'nik' => ['required', 'string', 'size:16', 'unique:users,nik'],
        'insurance_type' => ['required', 'in:umum,bpjs'],
        'bpjs_number' => [
            'nullable',
            'required_if:insurance_type,bpjs'
        ],
        'password' => ['required', 'confirmed'],
    ]);

    $user = User::create([
        'name' => $request->name,
        'nik' => $request->nik,
        'role' => 'patient',
        'insurance_type' => $request->insurance_type,
        'bpjs_number' => $request->insurance_type === 'bpjs'
            ? $request->bpjs_number
            : null,
        'password' => bcrypt($request->password),
    ]);

    Auth::login($user);

    return redirect()->route('patient.dashboard');
}
}