<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CollaboratorResource extends JsonResource
{
    private static array $typeMap = [
        0 => 'technician',
        1 => 'manager',
    ];

    public static array $reverseTypeMap = [
        'technician' => 0,
        'analyst'    => 0,
        'manager'    => 1,
    ];

    public function toArray($request): array
    {
        return [
            'id'       => (string) $this->id,
            'name'     => $this->name ?? '',
            'cpfCnpj'  => $this->cpf_cnpj !== null ? (string) $this->cpf_cnpj : '',
            'email'    => $this->email ?? '',
            'type'     => self::$typeMap[$this->type] ?? 'technician',
        ];
    }
}
