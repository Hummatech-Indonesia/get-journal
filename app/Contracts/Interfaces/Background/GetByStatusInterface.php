<?php

namespace App\Contracts\Interfaces\Background;

interface GetByStatusInterface
{
    public function getByStatus(bool $is_premium): mixed;
}
