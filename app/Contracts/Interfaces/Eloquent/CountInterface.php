<?php

namespace App\Contracts\Interfaces\Eloquent;

interface CountInterface
{
    /**
     * Handle count all data event from models.
     *
     * @param array|null $data
     *
     * @return int
     */

    public function count(?array $data): int;

}
