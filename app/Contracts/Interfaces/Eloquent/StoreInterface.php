<?php

namespace App\Contracts\Interfaces\Eloquent;

interface StoreInterface
{
    /**
     * Handle store method and store data instantly from models.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function store(array $data): mixed;
}
