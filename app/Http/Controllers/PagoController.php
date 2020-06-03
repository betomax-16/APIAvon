<?php

namespace App\Http\Controllers;

use App\User;
use App\Catalogo;
use App\Pedido;
use App\PedidoDetalle;
use App\Pago;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    public function get($id)
    {
        $pago = Pago::find($id);
        if ($pago) {
            return response()->json($pago);
        }
        else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    public function getUser($id)
    {
        $pagos = Pago::where(['idUsuario' => $id])->get();
        if ($pagos) {
            return response()->json($pagos);
        }
        else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    // public function getAdmin($id)
    // {
    //     $pagos = Pago::where(['idUsuario' => $id])->get();
    //     if ($pagos) {
    //         return response()->json($pagos);
    //     }
    //     else {
    //         return response()->json(['message' => 'Unauthorized'], 401);
    //     }
    // }

    public function create(Request $request)
    {
        $pago = new Pago([
            'idDetallePedido' => $request->idDetallePedido,
            'idUsuario' => $request->idUsuario,
            'monto' => $request->monto
        ]);
        $pago->save();

        return response()->json(['message' => 'Successfully created pago!'], 201);
    }

    public function update(Request $request, $id)
    {
        $pago = Pago::find($id);

        if ($pago) {
            $pago->monto = $request->monto != '' ? $request->monto : $pago->monto;

            $pago->save();
            return response()->json($pago);
        }
        else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    public function delete($id)
    {
        $pago = Pago::find($id);
        if ($pago) {
            $pago->delete();
            return response()->json(['message' => 'Delete success']);
        }
        else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }
}
