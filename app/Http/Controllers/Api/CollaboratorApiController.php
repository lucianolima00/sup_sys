<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CollaboratorResource;
use App\Models\Collaborator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CollaboratorApiController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return CollaboratorResource::collection(Collaborator::orderBy('name')->get());
    }

    public function show(Collaborator $collaborator): CollaboratorResource
    {
        return new CollaboratorResource($collaborator);
    }

    public function store(Request $request): CollaboratorResource
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'cpfCnpj' => 'nullable|string|max:20',
            'email'   => 'nullable|email|max:255',
            'type'    => 'required|string|in:technician,analyst,manager',
        ]);

        $collaborator = Collaborator::create([
            'name'      => $validated['name'],
            'cpf_cnpj'  => $validated['cpfCnpj'] ?? null,
            'email'     => $validated['email'] ?? null,
            'type'      => CollaboratorResource::$reverseTypeMap[$validated['type']] ?? 0,
        ]);

        return new CollaboratorResource($collaborator);
    }

    public function update(Request $request, Collaborator $collaborator): CollaboratorResource
    {
        $validated = $request->validate([
            'name'    => 'sometimes|required|string|max:255',
            'cpfCnpj' => 'nullable|string|max:20',
            'email'   => 'nullable|email|max:255',
            'type'    => 'sometimes|required|string|in:technician,analyst,manager',
        ]);

        $data = [];
        if (isset($validated['name'])) {
            $data['name'] = $validated['name'];
        }
        if (array_key_exists('cpfCnpj', $validated)) {
            $data['cpf_cnpj'] = $validated['cpfCnpj'];
        }
        if (array_key_exists('email', $validated)) {
            $data['email'] = $validated['email'];
        }
        if (isset($validated['type'])) {
            $data['type'] = CollaboratorResource::$reverseTypeMap[$validated['type']] ?? $collaborator->type;
        }

        $collaborator->update($data);

        return new CollaboratorResource($collaborator->fresh());
    }

    public function destroy(Collaborator $collaborator): Response
    {
        $collaborator->delete();

        return response()->noContent();
    }
}
