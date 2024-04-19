<?php

namespace App\Services;

use App\Http\Requests\Background\StoreRequest;

class BackgroundService
{
    public function handleUploadBackground(StoreRequest $request): array
    {
        $data = $request->validated();

        $data['image'] = $request->file('image')->store('background');

        return $data;
    }
}
