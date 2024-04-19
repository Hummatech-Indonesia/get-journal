<?php

namespace App\Http\Controllers\Api\Background;

use App\Contracts\Interfaces\BackgroundInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Background\StoreRequest;
use App\Http\Resources\BackgroundResource;
use App\Http\Resources\DefaultResource;
use App\Models\Background;
use App\Services\BackgroundService;
use Illuminate\Http\Request;

class BackgroundController extends Controller
{
    private BackgroundInterface $background;
    private BackgroundService $service;

    public function __construct(BackgroundInterface $background, BackgroundService $service)
    {
        $this->background = $background;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $backgrounds = $this->background->get();

        return BackgroundResource::collection($backgrounds)->response()->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $this->service->handleUploadBackground($request);
        $this->background->store($data);

        return DefaultResource::make([
            'code' => 201,
            'message' => 'Background berhasil ditambahkan',
        ], 201)->response()->setStatusCode(201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRequest $request, Background $background)
    {
        $data = $this->service->handleUpdateBackground($request);
        $this->background->update($background->id, $data);

        return DefaultResource::make([
            'code' => 200,
            'message' => 'Background berhasil diupdate',
        ])->response()->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Background $background)
    {
        $delete = $this->background->delete($background->id);
        if ($delete) {
            $this->service->handleDeleteBackground($background->image);

            return DefaultResource::make([
                'code' => 200,
                'message' => 'Background berhasil dihapus',
            ])->response()->setStatusCode(200);
        }

        return DefaultResource::make([
            'code' => 400,
            'message' => 'Background gagal dihapus',
        ], 400)->response()->setStatusCode(400);
    }
}
