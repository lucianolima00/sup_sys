<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'          => (string) $this->id,
            'name'        => $this->name ?? '',
            'companyName' => $this->company_name ?? '',
            'cpfCnpj'     => $this->cpf_cnpj !== null ? (string) $this->cpf_cnpj : '',
            'email'       => $this->email ?? '',
            'phone'       => $this->phone !== null ? (string) $this->phone : '',
            'logradouro'  => $this->address_public_place ?? '',
            'numero'      => $this->address_number ?? '',
            'complemento' => $this->address_complement ?? '',
            'cep'         => $this->address_zip_code !== null ? (string) $this->address_zip_code : '',
            'bairro'      => $this->address_neighborhood ?? '',
            'cidade'      => $this->address_city ?? '',
            'estado'      => $this->address_state ?? '',
        ];
    }
}
