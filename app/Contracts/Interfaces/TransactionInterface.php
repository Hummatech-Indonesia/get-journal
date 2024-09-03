<?php

namespace App\Contracts\Interfaces;

use App\Contracts\Interfaces\Assignment\ExportMarkInterface;
use App\Contracts\Interfaces\Assignment\GetByClassroomInterface;
use App\Contracts\Interfaces\Assignment\GetByLessonInterface;
use App\Contracts\Interfaces\Eloquent\CustomPaginationInterface;
use App\Contracts\Interfaces\Eloquent\DeleteInterface;
use App\Contracts\Interfaces\Eloquent\GetInterface;
use App\Contracts\Interfaces\Eloquent\GetWhereInterface;
use App\Contracts\Interfaces\Eloquent\PaginateInterface;
use App\Contracts\Interfaces\Eloquent\ShowInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface TransactionInterface extends StoreInterface, GetInterface, GetWhereInterface
{
    public function customPaginate(Request $request, int $pagination = 10): LengthAwarePaginator;

    public function customPaginateV2(Request $request, int $pagination = 10, int $page = 1): mixed;

    public function getDataExpired(array $data): mixed;
}
