<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Mostrar la lista de usuarios.
     */
    public function index()
    {
        $users = User::all();  // Obtener todos los usuarios
        return view('admin.user.index', compact('users'));
    }

    /**
     * Mostrar el formulario de creación de usuarios.
     */
    public function create()
    {
        return view('admin.user.create');  // Vista para el formulario de registro
    }

    /**
     * Guardar un nuevo usuario.
     */

public function store(Request $request)
{
    // Validación sin campo de 'role'
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);

    // Crear el usuario con rol predeterminado 'admin'
    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'role' => 'admin',  // Asignar rol 'admin' por defecto
    ]);

    // Redirigir a la lista de usuarios
    return redirect()->route('users.index')->with('success', 'Usuario creado correctamente.');
}


    public function edit($id)
{
    // Obtener el usuario por su id
    $user = User::findOrFail($id);
    
    // Retornar la vista con los datos del usuario
    return view('admin.user.edit', compact('user'));
}

public function update(Request $request, $id)
{
    // Validación de los datos del formulario
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],  // Excluir el email del usuario actual
        'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        'role' => ['nullable', 'in:admin,client'],
    ]);

    // Obtener el usuario a editar
    $user = User::findOrFail($id);

    // Actualizar los datos del usuario
    $user->update([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => $validated['password'] ? Hash::make($validated['password']) : $user->password,  // Solo cambiar la contraseña si se proporciona
        'role' => $validated['role'] ?? $user->role,  // Mantener el rol actual si no se cambia
    ]);

    // Redirigir con un mensaje de éxito
    return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente.');
}
public function destroy($id)
{
    // Obtener el usuario por su id
    $user = User::findOrFail($id);

    // Eliminar el usuario
    $user->delete();

    // Redirigir a la lista de usuarios con un mensaje de éxito
    return redirect()->route('users.index')->with('success', 'Usuario eliminado correctamente.');
}

    
}
