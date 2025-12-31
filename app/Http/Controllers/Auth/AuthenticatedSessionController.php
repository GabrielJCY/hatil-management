<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate(); 

        $request->session()->regenerate();

        $user = Auth::user(); 

        // 🛑 LOG DE DEPURACIÓN (Opcional): 
        // Si te sigue rebotando, revisa storage/logs/laravel.log para ver qué rol detecta.
        // \Log::info('Usuario logueado con rol: ' . ($user->rol_type ?? 'No definido'));

        $user_role = $user->rol_type ?? $user->role ?? $user->rol; 
        
        // Redirige según el rol usando rutas relativas para evitar errores de subcarpeta
        if ($user_role === 'admin' || $user_role === 'employee') { 
            return redirect('employee/dashboard'); 
        }
        
        if ($user_role === 'client') {
            return redirect('client/dashboard');
        }
        
        // Redirección por defecto
        return redirect('client/dashboard'); 
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}