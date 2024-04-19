<?php

namespace App\Services;

use App\Http\Requests\User\UpdateProfileRequest;
use Illuminate\Support\Facades\Storage;

class UserService
{
    public function handleUpdateProfileWithPhoto(UpdateProfileRequest $request): array
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photo');
            if (!is_null(auth()->user()->photo)) {
                if (Storage::exists(auth()->user()->photo)) Storage::delete(auth()->user()->photo);
            }
        }

        return $data;
    }
}
