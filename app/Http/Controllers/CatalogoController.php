<?php

namespace App\Http\Controllers;

use App\Catalogo;
use Illuminate\Http\Request;

class CatalogoController extends Controller
{

    public function create(Request $request)
    {
        $catalogo = new Catalogo([
            'idCatalogo' => uniqid(),
            'idUsuario'    => $request->idUsuario,
            'empresa' => $request->empresa,
            'fechaEmision' => $request->fechaEmision,
            'vigencia' => $request->vigencia,
            'estatus'    => $request->estatus,
            'imagenPath' => $request->imagenPath,
        ]);
        $catalogo->save();
        return response()->json(['message' => 'Successfully created catalogo!'], 201);
    }

    public function update(Request $request, $id)
    {
        $header = $request->header('Authorization');
        $catalogo = Catalogo::find($id);

        if ($catalogo) {
            $catalogo->empresa = $request->empresa != '' ? $request->empresa : $catalogo->empresa;
            $catalogo->fechaEmision = $request->fechaEmision != '' ? $request->fechaEmision : $catalogo->fechaEmision;
            $catalogo->vigencia = $request->vigencia != '' ? $request->vigencia : $catalogo->vigencia;
            $catalogo->estatus = $request->estatus != '' ? $request->estatus : $catalogo->estatus;
            $catalogo->imagenPath = $request->imagenPath != '' ? $request->imagenPath : $catalogo->imagenPath;

            $catalogo->save();
            return response()->json($catalogo);
        }
        else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    public function get($id)
    {
        // $header = $request->header('Authorization');
        $catalogo = Catalogo::find($id);

        if ($catalogo) {
            return response()->json($catalogo);
        }
        else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    public function delete($id)
    {
        // $header = $request->header('Authorization');
        $catalogo = Catalogo::find($id);

        if ($catalogo) {
            $catalogo->delete();
            return response()->json(['message' => 'Delete success']);
        }
        else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }
}
