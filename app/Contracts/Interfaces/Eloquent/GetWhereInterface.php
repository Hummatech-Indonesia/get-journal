<?php

namespace App\Contracts\Interfaces\Eloquent;

interface GetWhereInterface
{
    /**
     * Handle the Get all data event from models with filter data.
     *
     * @return mixed
     */

    public function getWhere(array $data): mixed;
}
