<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Validation\Rule; 
use Illuminate\Support\Facades\Hash; 
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::orderBy('name');
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
        }

        $users = $query->paginate(10)->withQueryString(); 
        
        return view('employee.users.index', compact('users'));
    }

    public function create()
    {
        return view('employee.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class], 
            'password' => ['required', 'confirmed', Rules\Password::defaults()], 
            // Validamos rol_type como string ('admin', 'employee', 'client')
            'rol_type' => ['required', 'string', Rule::in(['admin', 'employee', 'client'])],
            'carnet' => ['nullable', 'string', 'unique:'.User::class], 
        ]);

        $carnetValue = $request->carnet;
        
        // Lógica de carnet automático para clientes
        if (empty($carnetValue) && ($request->rol_type === 'client')) {
            $carnetValue = 'USR_' . time() . uniqid(); 
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol_type' => $request->rol_type, // Enviamos el texto: 'admin', 'employee' o 'client'
            'carnet' => $carnetValue, 
            'profile_id' => 1, // ID temporal, ajustalo según tu lógica de perfiles
        ]);

        return redirect()->route('admin.users.index')
                         ->with('success', 'El usuario "' . $user->name . '" ha sido creado correctamente.');
    }

    public function edit(User $user)
    {
        return view('employee.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'rol_type' => ['required', 'string', Rule::in(['admin', 'employee', 'client'])],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'carnet' => ['nullable', 'string', Rule::unique('users')->ignore($user->id)],
        ];

        if ($request->filled('password')) {
            $rules['password'] = ['confirmed', Rules\Password::defaults()];
        }

        $request->validate($rules);
        
        $data = [
            'name' => $request->name,
            'rol_type' => $request->rol_type, // 'admin', 'employee' o 'client'
            'email' => $request->email,
            'carnet' => $request->carnet,
        ];
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
                         ->with('success', 'El usuario "' . $user->name . '" ha sido actualizado.');
    }

    public function destroy(User $user) 
    {
        if (auth()->user()->id === $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $user->delete();
        
        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado.');
    }
}