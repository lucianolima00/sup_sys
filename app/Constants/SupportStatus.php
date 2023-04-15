<?php

namespace App\Constants;

class SupportStatus
{
    /**
     * @const int
     */
    const NOT_STARTED = 0;
    /**
     * @const int
     */
    const PENDING = 1;

    /**
     * @const int
     */
    const IN_PROGRESS = 2;

    /**
     * @const int
     */
    const DELIVER = 3;

    /**
     * @const int
     */
    const FINISHED = 4;

    public static function list(): array
    {
        return [
            self::NOT_STARTED => 'Não iniciado',
            self::PENDING => 'Pendente',
            self::IN_PROGRESS => 'Em andamento',
            self::DELIVER => 'Entregar',
            self::FINISHED => 'Finalizado',
        ];
    }
}
