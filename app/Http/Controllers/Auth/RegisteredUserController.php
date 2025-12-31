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

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'carnet'   => ['required', 'string', 'max:20', 'unique:users,carnet'], 
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name'       => $request->name,
            'carnet'     => $request->carnet, 
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'rol_type'   => 'client', 
            'profile_id' => null,     
        ]);

        event(new Registered($user));
        Auth::login($user);

        // IMPORTANTE: Redirigimos directo a la ruta del cliente para que no se pierda la sesión
        return redirect()->route('client.dashboard')
            ->with('success', '¡Su registro fue un éxito! Bienvenido a HATIL.');
    }
}