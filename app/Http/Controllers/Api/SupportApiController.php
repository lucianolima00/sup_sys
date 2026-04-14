<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SupportResource;
use App\Models\Support;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class SupportApiController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $supports = Support::with(['client', 'primary_collaborator', 'secondary_collaborator', 'requester'])
            ->orderByDesc('created_at')
            ->get();

        return SupportResource::collection($supports);
    }

    public function show(Support $support): SupportResource
    {
        $support->load(['client', 'primary_collaborator', 'secondary_collaborator', 'requester']);

        return new SupportResource($support);
    }

    public function store(Request $request): SupportResource
    {
        $validated = $request->validate([
            'openingDate'            => 'required|date',
            'status'                 => 'required|string',
            'clientId'               => 'required|exists:clients,id',
            'primaryCollaboratorId'  => 'required|exists:collaborators,id',
            'secondaryCollaboratorId'=> 'nullable|exists:collaborators,id',
            'requesterId'            => 'nullable|exists:collaborators,id',
            'scheduledStart'         => 'nullable|date',
            'description'            => 'nullable|string',
            'solution'               => 'nullable|string',
            'addressOverride'        => 'nullable|array',
        ]);

        $support = Support::create([
            'opening_date'               => $validated['openingDate'],
            'status'                     => SupportResource::$reverseStatusMap[$validated['status']] ?? 0,
            'client_id'                  => $validated['clientId'],
            'primary_collaborator_id'    => $validated['primaryCollaboratorId'],
            'secondary_collaborator_id'  => $validated['secondaryCollaboratorId'] ?? null,
            'requester_id'               => $validated['requesterId'] ?? null,
            'start_datetime'             => $validated['scheduledStart'] ?? null,
            'description'                => $validated['description'] ?? null,
            'solution'                   => $validated['solution'] ?? null,
            'address'                    => $validated['addressOverride'] ?? null,
        ]);

        return new SupportResource($support);
    }

    public function update(Request $request, Support $support): SupportResource
    {
        $validated = $request->validate([
            'openingDate'            => 'sometimes|required|date',
            'status'                 => 'sometimes|required|string',
            'clientId'               => 'sometimes|required|exists:clients,id',
            'primaryCollaboratorId'  => 'sometimes|required|exists:collaborators,id',
            'secondaryCollaboratorId'=> 'nullable|exists:collaborators,id',
            'requesterId'            => 'nullable|exists:collaborators,id',
            'scheduledStart'         => 'nullable|date',
            'description'            => 'nullable|string',
            'solution'               => 'nullable|string',
            'addressOverride'        => 'nullable|array',
        ]);

        $data = [];

        if (isset($validated['openingDate'])) {
            $data['opening_date'] = $validated['openingDate'];
        }
        if (isset($validated['status'])) {
            $data['status'] = SupportResource::$reverseStatusMap[$validated['status']] ?? $support->status;
        }
        if (isset($validated['clientId'])) {
            $data['client_id'] = $validated['clientId'];
        }
        if (isset($validated['primaryCollaboratorId'])) {
            $data['primary_collaborator_id'] = $validated['primaryCollaboratorId'];
        }
        if (array_key_exists('secondaryCollaboratorId', $validated)) {
            $data['secondary_collaborator_id'] = $validated['secondaryCollaboratorId'];
        }
        if (array_key_exists('requesterId', $validated)) {
            $data['requester_id'] = $validated['requesterId'];
        }
        if (array_key_exists('scheduledStart', $validated)) {
            $data['start_datetime'] = $validated['scheduledStart'];
        }
        if (array_key_exists('description', $validated)) {
            $data['description'] = $validated['description'];
        }
        if (array_key_exists('solution', $validated)) {
            $data['solution'] = $validated['solution'];
        }
        if (array_key_exists('addressOverride', $validated)) {
            $data['address'] = $validated['addressOverride'];
        }

        $support->update($data);

        return new SupportResource($support->fresh());
    }

    public function destroy(Support $support): Response
    {
        $support->delete();

        return response()->noContent();
    }
}
