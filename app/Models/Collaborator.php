<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collaborator extends Model
{
    use HasFactory;

    protected $table = 'collaborators';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'cpf_cnpj',
        'email',
        'type',
        'created_at'
    ];
}
