<?php

namespace App\Contracts\Interfaces\User;

use App\Contracts\Interfaces\Eloquent\ShowInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;
use App\Contracts\Interfaces\Student\CheckAvailableStudentInterface;
use Illuminate\Http\Request;

interface ProfileInterface extends GetUserInfoInterface, GetProfileByEmailInterface, StoreInterface, CheckAvailableStudentInterface, UpdateInterface
{
    public function getWhereData(array $data): mixed;

    public function getDataStudent(Request $request): mixed;

    public function detailStudent(mixed $id): mixed;

    public function getDataHasExpiredPremium(): mixed;
}
