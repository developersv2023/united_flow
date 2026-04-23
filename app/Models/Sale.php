<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha',
        'awb',
        'agency_id',
        'client_id',
        'peso',
        'tarifa_publica',
        'tarifa_neta',
        'flete_p',
        'flete_n',
        'gastos_gc',
        'gastos_oa',
        'incentivo',
        'diferencial',
        'sobreventa',
        'tarifa_ajuste',
        'total_pp',
        'total_cc',
    ];

    protected $casts = [
        'fecha' => 'date',
        'peso' => 'decimal:2',
        'tarifa_publica' => 'decimal:4',
        'tarifa_neta' => 'decimal:4',
        'flete_p' => 'decimal:2',
        'flete_n' => 'decimal:2',
        'gastos_gc' => 'decimal:2',
        'gastos_oa' => 'decimal:2',
        'incentivo' => 'decimal:2',
        'diferencial' => 'decimal:2',
        'sobreventa' => 'decimal:2',
        'tarifa_ajuste' => 'decimal:2',
        'total_pp' => 'decimal:2',
        'total_cc' => 'decimal:2',
    ];

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
