<?php

namespace App\Http\Controllers;

use App\User;
use App\Catalogo;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function catalogos($id)
    {
        //
        $user = User::find($id);
        if ($user) {
            return Catalogo::where('idUsuario', $user->idUsuario)->get();
            // return Catalogo::where->where('idUsuario', $user->idUsuario);
            // return response()->json($user->catalogos());
        }
        else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    public function signup(Request $request)
    {
        $request->validate([
            'nombre'     => 'required|string',
            'email'    => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
        ]);
        $user = new User([
            'idUsuario' => uniqid(),
            'nombre'    => $request->nombre,
            'apellidos' => $request->apellidos,
            'alias' => $request->alias,
            'telefono' => $request->telefono,
            'email'    => $request->email,
            'direccion' => $request->direccion,
            'tipo' => $request->tipo,
            'password' => password_hash($request->password, PASSWORD_DEFAULT),
        ]);
        $user->save();
        return response()->json(['message' => 'Successfully created user!'], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'       => 'required|string|email',
            'password'    => 'required|string',
        ]);

        $user = User::firstWhere('email', $request->email);

        if ($user) {
            if (password_verify($request->password, $user->password)) {
                return response()->json($user);
            }
            else {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
        }
        else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    public function update(Request $request, $id)
    {
        $header = $request->header('Authorization');
        $user = User::find($id);

        if ($user) {
            $user->nombre = $request->nombre != '' ? $request->nombre : $user->nombre;
            $user->apellidos = $request->apellidos != '' ? $request->apellidos : $user->apellidos;
            $user->alias = $request->alias != '' ? $request->alias : $user->alias;
            $user->telefono = $request->telefono != '' ? $request->telefono : $user->telefono;
            $user->email = $request->email != '' ? $request->email : $user->email;
            $user->direccion = $request->direccion != '' ? $request->direccion : $user->direccion;
            $user->tipo = $request->tipo != '' ? $request->tipo : $user->tipo;

            if ($request->password != '') {
                $user->password = password_hash($request->password, PASSWORD_DEFAULT);
            }

            $user->save();
            return response()->json($user);
        }
        else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    public function get($id)
    {
        // $header = $request->header('Authorization');
        $user = User::find($id);

        if ($user) {
            return response()->json($user);
        }
        else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    public function delete($id)
    {
        // $header = $request->header('Authorization');
        $user = User::find($id);

        if ($user) {
            $user->delete();
            return response()->json(['message' => 'Delete success']);
        }
        else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }
}
