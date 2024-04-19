<?php

namespace App\Contracts\Interfaces\Background;

interface GetByStatusInterface
{
    public function getByStatus(mixed $is_premium): mixed;
}
