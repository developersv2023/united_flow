<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'factura_num',
        'fecha_emision',
        'mes_facturado',
        'monto',
        'dias_vencido',
        'estado',
    ];

    /**
     * Mutator to easily ensure cast for dates if needed, though $casts is cleaner
     */
    protected $casts = [
        'fecha_emision' => 'date',
        'monto' => 'decimal:2',
        'dias_vencido' => 'integer',
    ];
}
