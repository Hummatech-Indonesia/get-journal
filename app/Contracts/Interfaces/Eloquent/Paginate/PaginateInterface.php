<?php

namespace App\Contracts\Interfaces\Eloquent\Paginate;

use Illuminate\Pagination\LengthAwarePaginator;

interface PaginateInterface
{
    /**
     * Handle paginate data event from models.
     *
     * @param int $pagination
     *
     * @return LengthAwarePaginator
     */

    public function paginate(int $pagination = 10): LengthAwarePaginator;
}
