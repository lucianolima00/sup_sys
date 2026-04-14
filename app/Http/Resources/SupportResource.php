<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SupportResource extends JsonResource
{
    private static array $statusMap = [
        0 => 'open',
        1 => 'open',
        2 => 'in_progress',
        3 => 'awaiting_client',
        4 => 'resolved',
        5 => 'cancelled',
    ];

    public static array $reverseStatusMap = [
        'open'            => 0,
        'in_progress'     => 2,
        'awaiting_client' => 3,
        'resolved'        => 4,
        'closed'          => 4,
        'cancelled'       => 5,
    ];

    public function toArray($request): array
    {
        return [
            'id'                      => (string) $this->id,
            'status'                  => self::$statusMap[$this->status] ?? 'open',
            'clientId'                => (string) $this->client_id,
            'primaryCollaboratorId'   => $this->primary_collaborator_id
                                            ? (string) $this->primary_collaborator_id
                                            : null,
            'secondaryCollaboratorId' => $this->secondary_collaborator_id
                                            ? (string) $this->secondary_collaborator_id
                                            : null,
            'requesterId'             => $this->requester_id
                                            ? (string) $this->requester_id
                                            : null,
            'openingDate'             => $this->opening_date,
            'scheduledStart'          => $this->start_datetime,
            'description'             => $this->description ?? '',
            'solution'                => $this->solution ?? '',
            'createdAt'               => $this->created_at?->toISOString(),
            'addressOverride'         => $this->address,
        ];
    }
}
