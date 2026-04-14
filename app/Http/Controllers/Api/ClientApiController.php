<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ClientApiController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return ClientResource::collection(Client::orderBy('name')->get());
    }

    public function show(Client $client): ClientResource
    {
        return new ClientResource($client);
    }

    public function store(Request $request): ClientResource
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'companyName' => 'nullable|string|max:255',
            'cpfCnpj'     => 'nullable|string|max:20',
            'email'       => 'nullable|email|max:255',
            'phone'       => 'nullable|string|max:20',
            'logradouro'  => 'nullable|string|max:255',
            'numero'      => 'nullable|string|max:20',
            'complemento' => 'nullable|string|max:255',
            'cep'         => 'nullable|string|max:10',
            'bairro'      => 'nullable|string|max:255',
            'cidade'      => 'nullable|string|max:255',
            'estado'      => 'nullable|string|max:2',
        ]);

        $client = Client::create([
            'name'                 => $validated['name'],
            'company_name'         => $validated['companyName'] ?? null,
            'cpf_cnpj'             => $validated['cpfCnpj'] ?? null,
            'email'                => $validated['email'] ?? null,
            'phone'                => $validated['phone'] ?? null,
            'address_public_place' => $validated['logradouro'] ?? null,
            'address_number'       => $validated['numero'] ?? null,
            'address_complement'   => $validated['complemento'] ?? null,
            'address_zip_code'     => $validated['cep'] ?? null,
            'address_neighborhood' => $validated['bairro'] ?? null,
            'address_city'         => $validated['cidade'] ?? null,
            'address_state'        => $validated['estado'] ?? null,
        ]);

        return new ClientResource($client);
    }

    public function update(Request $request, Client $client): ClientResource
    {
        $validated = $request->validate([
            'name'        => 'sometimes|required|string|max:255',
            'companyName' => 'nullable|string|max:255',
            'cpfCnpj'     => 'nullable|string|max:20',
            'email'       => 'nullable|email|max:255',
            'phone'       => 'nullable|string|max:20',
            'logradouro'  => 'nullable|string|max:255',
            'numero'      => 'nullable|string|max:20',
            'complemento' => 'nullable|string|max:255',
            'cep'         => 'nullable|string|max:10',
            'bairro'      => 'nullable|string|max:255',
            'cidade'      => 'nullable|string|max:255',
            'estado'      => 'nullable|string|max:2',
        ]);

        $map = [
            'name'        => 'name',
            'companyName' => 'company_name',
            'cpfCnpj'     => 'cpf_cnpj',
            'email'       => 'email',
            'phone'       => 'phone',
            'logradouro'  => 'address_public_place',
            'numero'      => 'address_number',
            'complemento' => 'address_complement',
            'cep'         => 'address_zip_code',
            'bairro'      => 'address_neighborhood',
            'cidade'      => 'address_city',
            'estado'      => 'address_state',
        ];

        $data = [];
        foreach ($map as $reactKey => $dbKey) {
            if (array_key_exists($reactKey, $validated)) {
                $data[$dbKey] = $validated[$reactKey];
            }
        }

        $client->update($data);

        return new ClientResource($client->fresh());
    }

    public function destroy(Client $client): Response
    {
        $client->delete();

        return response()->noContent();
    }
}
