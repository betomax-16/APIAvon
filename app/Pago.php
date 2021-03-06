<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $primaryKey = 'idPago';
    public $incrementing = false;
    protected $keyType = 'string';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idPago', 'idDetallePedido', 'idUsuario', 'monto'
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

    public function usuario()
    {
        return $this->belongsTo('App\User', 'idUsuario');
    }

    public function producto()
    {
        return $this->hasMany('App\PedidoDetalle', 'idPedido', 'idPedido');
    }
}
