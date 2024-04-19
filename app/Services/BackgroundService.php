<?php

namespace App\Services;

use App\Http\Requests\Background\StoreRequest;
use Illuminate\Support\Facades\Storage;

class BackgroundService
{
    public function handleUploadBackground(StoreRequest $request): array
    {
        $data = $request->validated();

        $data['image'] = $request->file('image')->store('background');

        return $data;
    }

    public function handleUpdateBackground(StoreRequest $request): array
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('background');
        }

        if (Storage::exists($data['image'])) Storage::delete($data['image']);

        return $data;
    }

    public function handleDeleteBackground(string $image): void
    {
        if (Storage::exists($image)) Storage::delete($image);
    }
}
