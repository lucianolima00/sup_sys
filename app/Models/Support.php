<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    use HasFactory;

    protected $table = 'supports';

    public static $statusList = [
        0 => 'Não iniciado',
        1 => 'Pendente',
        2 => 'Em Andamento',
        3 => 'Entregar',
        4 => 'Finalizado',
    ];

    public $timestamps = true;

    protected $fillable = [
        'opening_date',
        'status',
        'primary_collaborator_id',
        'secondary_collaborator_id',
        'start_datetime',
        'client_id',
        'address',
        'requester_id',
        'description',
        'solution',
    ];
}
