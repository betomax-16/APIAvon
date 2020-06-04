<?php

namespace App\Http\Controllers;

use App\User;
use App\Catalogo;
use App\Pedido;
use App\DetallePedido;
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
                $DetallePedido = new DetallePedido([
                    'idDetallePedido' => uniqid(),
                    'idPedido' => $pedido->idPedido,
                    'idProducto' => $value['idProducto'],
                    'idCatalogo' => $value['idCatalogo'],
                    'detalle' => $value['detalle'],
                    'cantidad' => $value['cantidad'],
                    'precioUnitario' => $value['precioUnitario'],
                    'estatus' => $value['estatus']
                ]);
                $DetallePedido->save();
            }
        }

        return response()->json(['message' => 'Successfully created pedido!'], 201);
    }

    public function get($id)
    {
        $pedido = Pedido::find($id);
        if ($pedido) {
            $DetallePedido = DetallePedido::where(['idPedido' => $id])->get();
            $pedido->productos = $DetallePedido;
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
        $pedidos = Pedido::where(['idUsuario' => $id, 'estatus' => 'En Proceso'])->get();
        if ($pedidos) {
            foreach ($pedidos as $key => $value) {
                $value['productos'] = DetallePedido::where(['idPedido' => $value->idPedido])->get();
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
                $DetallePedido = DetallePedido::groupBy('idPedido')->havingRaw('idCatalogo = \''.$value->idCatalogo.'\' and estatus = \'En Proceso\'')->get();

                foreach ($DetallePedido as $key2 => $value2) {
                    $pedido = Pedido::find($value2->idPedido);
                    array_push($pedidosAux, $pedido);
                }

                foreach ($pedidosAux as $key3 => $value3) {
                    $value3->productos = DetallePedido::where(['idPedido' => $value3->idPedido])->get();
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
        $DetallePedido = DetallePedido::find($id);
        if ($DetallePedido) {
            return response()->json($DetallePedido);
        }
        else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    public function addDetalle(Request $request)
    {
        $body = json_decode($request->getContent());
        if (is_array($body)) {
            $body = json_decode($request->getContent(), true);
            foreach ($body as $key => $value) {
                $DetallePedido = new DetallePedido([
                    'idDetallePedido' => uniqid(),
                    'idPedido' => $value['idPedido'],
                    'idProducto' => $value['idProducto'],
                    'idCatalogo' => $value['idCatalogo'],
                    'detalle' => $value['detalle'],
                    'cantidad' => $value['cantidad'],
                    'precioUnitario' => $value['precioUnitario'],
                    'estatus' => $value['estatus']
                ]);
                $DetallePedido->save();
            }
        }
        else {
            $DetallePedido = new DetallePedido([
                'idDetallePedido' => uniqid(),
                'idPedido' => $request->idPedido,
                'idProducto' => $request->idProducto,
                'idCatalogo' => $request->idCatalogo,
                'detalle' => $request->detalle,
                'cantidad' => $request->cantidad,
                'precioUnitario' => $request->precioUnitario,
                'estatus' => $request->estatus
            ]);
            $DetallePedido->save();
        }
        return response()->json(['message' => 'Successfully created detalle!'], 201);
    }

    public function updateDetalle(Request $request, $id)
    {
        $DetallePedido = DetallePedido::find($id);
        if ($DetallePedido) {
            $DetallePedido->idProducto = $request->idProducto != '' ? $request->idProducto : $DetallePedido->idProducto;
            $DetallePedido->idCatalogo = $request->idCatalogo != '' ? $request->idCatalogo : $DetallePedido->idCatalogo;
            $DetallePedido->detalle = $request->detalle != '' ? $request->detalle : $DetallePedido->detalle;
            $DetallePedido->cantidad = $request->cantidad != '' ? $request->cantidad : $DetallePedido->cantidad;
            $DetallePedido->precioUnitario = $request->precioUnitario != '' ? $request->precioUnitario : $DetallePedido->precioUnitario;
            $DetallePedido->estatus = $request->estatus != '' ? $request->estatus : $DetallePedido->estatus;

            $DetallePedido->save();
            return response()->json($DetallePedido);
        }
        else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    public function deleteDetalle($id)
    {
        $DetallePedido = DetallePedido::find($id);
        if ($DetallePedido) {
            $DetallePedido->delete();
            return response()->json(['message' => 'Delete success']);
        }
        else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }
}
