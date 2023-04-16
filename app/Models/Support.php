<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    use HasFactory;

    protected $table = 'supports';

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

    public function primary_collaborator(): HasOne
    {
        return $this->hasOne(Collaborator::class, 'id', 'primary_collaborator_id');
    }

    public function secondary_collaborator(): HasOne
    {
        return $this->hasOne(Collaborator::class, 'id', 'secondary_collaborator_id');
    }

    public function client(): HasOne
    {
        return $this->hasOne(Client::class, 'id', 'client_id');
    }

    public function requester(): HasOne
    {
        return $this->hasOne(Collaborator::class, 'id', 'requester_id');
    }
}
