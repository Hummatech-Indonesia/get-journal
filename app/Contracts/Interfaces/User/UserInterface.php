<?php

namespace App\Contracts\Interfaces\User;

use App\Contracts\Interfaces\Eloquent\DeleteInterface;
use App\Contracts\Interfaces\Eloquent\GetWhereInterface;
use App\Contracts\Interfaces\Eloquent\ShowInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;
use Illuminate\Http\Request;

interface UserInterface extends StoreInterface, UpdatePasswordInterface, UpdateInterface, DeleteInterface, ShowInterface, GetWhereInterface
{
    // custom query for data
    public function customQuery(Request $request): mixed;
    
    public function getWhereData(array $data): mixed;
}
