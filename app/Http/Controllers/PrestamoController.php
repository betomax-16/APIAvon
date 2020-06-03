<?php

namespace App\Http\Controllers;

use App\User;
use App\Catalogo;
use App\Prestamo;
use Illuminate\Http\Request;

class PrestamoController extends Controller
{

    public function create(Request $request)
    {
        $prestamo = new Prestamo([
            'idCatalogo' => $request->idCatalogo,
            'idUsuario'    => $request->idUsuario
        ]);
        $prestamo->save();
        $catalogo = Catalogo::find($request->idCatalogo);

        if ($catalogo) {
            $catalogo->estatus = 'prestado';
            $catalogo->save();
            return response()->json(['message' => 'Successfully created prestamo!'], 201);
        }
        else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    public function getAll($id)
    {
        $catalogos = Catalogo::where(['idUsuario' => $id, 'estatus' => 'prestado'])->get();
        if ($catalogos) {
            return response()->json($catalogos, 201);
        }
        else {
            return response()->json(['message' => 'Not found'], 401);
        }
    }

    public function get(Request $request)
    {
        $prestamo = Prestamo::where(['idCatalogo' => $request->idCatalogo, 'idUsuario' => $request->idUsuario])->order_by('upload_time', 'desc')->first();
        if ($prestamo) {
            $user = User::find($prestamo->idUsuario);
            $catalogo = Catalogo::find($prestamo->idCatalogo);
            return response()->json(['usuario' => $user, 'catalogo' => $catalogo], 201);
        }
        else {
            return response()->json(['message' => 'Not found'], 401);
        }
    }

    public function update(Request $request, $id)
    {
        $catalogo = Catalogo::find($id);

        if ($catalogo) {
            $catalogo->estatus = $request->estatus != '' ? $request->estatus : $catalogo->estatus;
            $catalogo->save();
            return response()->json($catalogo);
        }
        else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }
}
