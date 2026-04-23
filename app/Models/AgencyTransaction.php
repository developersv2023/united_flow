<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgencyTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'agency_id',
        'quincena_periodo',
        'fecha_transaccion',
        'awb_referencia',
        'flete_pp',
        'flete_cc',
        'tax',
        'due_agent',
        'total_due_airline',
        'subtotal',
        'comision',
        'iva_comision',
        'total_pp',
        'total_cc',
        'cargos_debitos',
        'abonos_creditos',
        'saldo_acumulado'
    ];

    protected $casts = [
        'fecha_transaccion' => 'date',
    ];

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }
}
