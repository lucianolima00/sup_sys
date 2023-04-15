<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collaborator extends Model
{
    use HasFactory;

    protected $table = 'collaborators';

    public static $typeList = [
        0 => 'Técnico',
        1 => 'Solicitante',
    ];
    public $timestamps = true;

    protected $fillable = [
        'name',
        'cpf_cnpj',
        'email',
        'type',
        'created_at'
    ];
}
