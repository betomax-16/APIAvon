<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Catalogo extends Model
{
    protected $primaryKey = 'idCatalogo';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idCatalogo', 'idUsuario', 'empresa', 'fechaEmision', 'vigencia', 'estatus', 'imagenPath'
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
        'fechaEmision' => 'date',
        'vigencia' => 'date',
    ];

    public function usuario()
    {
        return $this->belongsTo('App\User', 'idUsuario');
    }

    public function prestamo()
    {
        return $this->hasMany('App\Prestamo', 'idPedido', 'idPedido');
    }
}
