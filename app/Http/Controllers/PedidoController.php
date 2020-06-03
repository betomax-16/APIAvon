<?php

namespace App\Http\Controllers;

use App\User;
use App\Catalogo;
use App\Pedido;
use App\PedidoDetalle;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function create(Request $request)
    {
        $pedido = new Pedido([
            'idPedido' => uniqid(),
            'idUsuario' => $request->idUsuario,
            'precioTotal' => $request->precioTotal,
            'estatus' => $request->estatus
        ]);
        $pedido->save();

        if ($request->productos) {
            foreach ($request->productos as $key => $value) {
                $pedidoDetalle = new PedidoDetalle([
                    'idDetallePedido' => uniqid(),
                    'idPedido' => $pedido->idPedido,
                    'idProducto' => $value->idProducto,
                    'idCatalogo' => $value->idCatalogo,
                    'detalle' => $value->detalle,
                    'cantidad' => $value->cantidad,
                    'precioUnitario' => $value->precioUnitario,
                    'estatus' => $value->estatus
                ]);
                $pedidoDetalle->save();
            }
        }

        return response()->json(['message' => 'Successfully created pedido!'], 201);
    }

    public function get($id)
    {
        $pedido = Pedido::find($id);
        if ($pedido) {
            $pedidoDetalle = PedidoDetalle::where(['idPedido' => $id])->get();
            $pedido->productos = $pedidoDetalle;
            return response()->json($pedido);
        }
        else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    public function update(Request $request, $id)
    {
        $pedido = Pedido::find($id);

        if ($pedido) {
            $pedido->precioTotal = $request->precioTotal != '' ? $request->precioTotal : $pedido->precioTotal;
            $pedido->estatus = $request->estatus != '' ? $request->estatus : $pedido->estatus;

            $pedido->save();
            return response()->json($pedido);
        }
        else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    public function getUser($id)
    {
        $pedidos = Pedido::where(['idUsuario' => $id, 'estatus' => 'en progreso'])->get();
        if ($pedidos && is_array($pedidos)) {
            foreach ($pedidos as $key => $value) {
                $value->productos = array();
                $pedidoDetalle = PedidoDetalle::where(['idPedido' => $value->idPedido])->get();
                array_push($pedido->productos, $pedidoDetalle);
            }
            return response()->json($pedidos);
        }
    }

    public function getAdmin($id)
    {
        $pedidosAux = array();
        $user = User::find($id);
        if ($user) {
            $catalogos = Catalogo::where('idUsuario', $user->idUsuario)->get();
            foreach ($catalogos as $key => $value) {
                $pedidoDetalle = PedidoDetalle::where(['idCatalogo' => $value->idCatalogo, 'estatus' => 'en progreso'])->get();

                foreach ($pedidoDetalle as $key2 => $value2) {
                    if (!isset($pedidosAux[$value2->idPedido])) {
                        $pedido = Pedido::find($value2->idPedido);
                        array_push($pedidosAux, $pedido);
                    }
                }

                foreach ($pedidosAux as $key3 => $value3) {
                    $value3->productos = array();
                    $pedidoDetalle = PedidoDetalle::where(['idPedido' => $value3->idPedido])->get();
                    array_push($value3->productos, $pedidoDetalle);
                }

                return response()->json($pedidosAux);
            }
        }
        else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }


    public function getDetalle($id)
    {
        $pedidoDetalle = PedidoDetalle::find($id);
        if ($pedidoDetalle) {
            return response()->json($pedidos);
        }
        else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    public function addDetalle(Request $request)
    {
        if (is_array($request)) {
            foreach ($request as $key => $value) {
                $pedidoDetalle = new PedidoDetalle([
                    'idDetallePedido' => uniqid(),
                    'idPedido' => $value->idPedido,
                    'idProducto' => $value->idProducto,
                    'idCatalogo' => $value->idCatalogo,
                    'detalle' => $value->detalle,
                    'cantidad' => $value->cantidad,
                    'precioUnitario' => $value->precioUnitario,
                    'estatus' => $value->estatus
                ]);
                $pedidoDetalle->save();
            }
        }
        else {
            $pedidoDetalle = new PedidoDetalle([
                'idDetallePedido' => uniqid(),
                'idPedido' => $request->idPedido,
                'idProducto' => $request->idProducto,
                'idCatalogo' => $request->idCatalogo,
                'detalle' => $request->detalle,
                'cantidad' => $request->cantidad,
                'precioUnitario' => $request->precioUnitario,
                'estatus' => $request->estatus
            ]);
            $pedidoDetalle->save();
        }
        return response()->json(['message' => 'Successfully created detalle!'], 201);
    }

    public function updateDetalle(Request $request, $id)
    {
        $pedidoDetalle = PedidoDetalle::find($id);
        if ($pedidoDetalle) {
            $pedidoDetalle->idProducto = $request->idProducto != '' ? $request->idProducto : $pedidoDetalle->idProducto;
            $pedidoDetalle->idCatalogo = $request->idCatalogo != '' ? $request->idCatalogo : $pedidoDetalle->idCatalogo;
            $pedidoDetalle->detalle = $request->detalle != '' ? $request->detalle : $pedidoDetalle->detalle;
            $pedidoDetalle->cantidad = $request->cantidad != '' ? $request->cantidad : $pedidoDetalle->cantidad;
            $pedidoDetalle->precioUnitario = $request->precioUnitario != '' ? $request->precioUnitario : $pedidoDetalle->precioUnitario;
            $pedidoDetalle->estatus = $request->estatus != '' ? $request->estatus : $pedidoDetalle->estatus;

            $pedidoDetalle->save();
            return response()->json($pedidoDetalle);
        }
        else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    public function deleteDetalle($id)
    {
        $pedidoDetalle = PedidoDetalle::find($id);
        if ($pedidoDetalle) {
            $pedidoDetalle->delete();
            return response()->json(['message' => 'Delete success']);
        }
        else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }
}
