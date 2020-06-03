<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PedidoDetalle extends Model
{
    protected $primaryKey = 'idDetallePedido';
    public $incrementing = false;
    protected $keyType = 'string';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idDetallePedido', 'idPedido', 'idProducto', 'idCatalogo', 'detalle', 'cantidad', 'precioUnitario', 'estatus'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        
    ];

    public function pedido()
    {
        return $this->hasMany('App\Pedido', 'idPedido', 'idPedido');
    }

    public function catalogo()
    {
        return $this->hasMany('App\Catalogo', 'idCatalogo', 'idCatalogo');
    }
}
