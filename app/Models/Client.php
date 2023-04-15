<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'company_name',
        'cpf_cnpj',
        'email',
        'phone',
        'address_public_place',
        'address_number',
        'address_complement',
        'address_zip_code',
        'address_neighborhood',
        'address_city',
        'address_state',
    ];
}
