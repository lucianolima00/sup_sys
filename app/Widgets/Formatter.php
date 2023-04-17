<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use LaravelLegends\PtBrValidator\Rules\Cnpj;
use LaravelLegends\PtBrValidator\Rules\Cpf;

class Formatter extends AbstractWidget
{
    /**
     * @param string $cpf_cnpj
     * @param bool $punctuation
     * @return string|null
     */
    public static function asCpfCnpj(?string $cpf_cnpj, bool $punctuation=true, bool $validation=true): ?string
    {
        if ((new Cpf())->passes('cpf_cnpj', str_pad($cpf_cnpj, 11, 0, STR_PAD_LEFT)) || (!$validation && strlen($cpf_cnpj) <= 11)) {
            $cpf_cnpj = str_pad($cpf_cnpj, 11, 0, STR_PAD_LEFT);

            if ($punctuation) {
                $cpf_cnpj = preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '${1}.${2}.${3}-${4}', $cpf_cnpj);
            }
        } else if ((new Cnpj())->passes('cpf_cnpj', str_pad($cpf_cnpj, 14, 0, STR_PAD_LEFT))|| (!$validation && strlen($cpf_cnpj) <= 14)) {
            $cpf_cnpj = str_pad($cpf_cnpj, 14, 0, STR_PAD_LEFT);

            if ($punctuation) {
                $cpf_cnpj = preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '${1}.${2}.${3}/${4}-${5}', $cpf_cnpj);
            }
        }

        return $cpf_cnpj;
    }

    /**
     * @param $phone
     * @return string|null
     */
    public static function asPhone(?string $phone): ?string
    {
        if (strlen($phone) === 10) {
            return preg_replace('/(\d{2})(\d{4})(\d{4})/', '(${1}) ${2}-${3}', $phone);
        } elseif (strlen($phone) === 11) {
            return preg_replace('/(\d{2})(\d)(\d{4})(\d{4})/', '(${1}) ${2} ${3}-${4}', $phone);
        } else {
            return $phone;
        }
    }

    /**
     * @param $cep
     * @return string|null
     */
    public static function asCep(?string $cep): ?string
    {
        $cep = str_pad($cep, 8, 0, STR_PAD_LEFT);

        return preg_replace('/(\d{5})(\d{3})/', '${1}-${2}', $cep);
    }

    /**
     * @param $date
     * @return string|null
     */
    public static function asDate(?string $date): ?string
    {
        return preg_replace('/^(\d{4})-(\d{2})-(\d{2})$/', '$3/$2/$1', $date);
    }

    /**
     * @param $datetime
     * @return string|null
     */
    public static function asDatetime(?string $datetime): ?string
    {
        $datetime = str_pad($datetime, 8, 0, STR_PAD_LEFT);

        return preg_replace('/^(\d{4})-(\d{2})-(\d{2})\s+(\d{2}):(\d{2}):(\d{2})$/', '$3/$2/$1 $4:$5:$6', $datetime);
    }


    /**
     * @param $id
     * @return string|null
     */
    public static function asID(?string $id): ?string
    {
        return '#' . str_pad($id, 6, 0, STR_PAD_LEFT);
    }
}
