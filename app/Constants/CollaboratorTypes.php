<?php

namespace App\Constants;

class CollaboratorTypes
{
    const TECHNIQUE = 0;
    const REQUESTER = 1;

    public static function list(): array
    {
        return [
            self::TECHNIQUE => 'Técnico',
            self::REQUESTER => 'Solicitante',
        ];
    }
}
