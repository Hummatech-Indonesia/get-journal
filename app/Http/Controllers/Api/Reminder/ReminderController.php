<?php

namespace App\Http\Controllers\Api\Reminder;

use App\Contracts\Interfaces\ReminderInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Reminder\StoreRequest;
use App\Http\Requests\Reminder\UpdateRequest;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\ReminderResource;
use Illuminate\Http\Request;

class ReminderController extends Controller
{
    private ReminderInterface $reminder;

    public function __construct(ReminderInterface $reminder)
    {
        $this->reminder = $reminder;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reminders = $this->reminder->getReminderByUser(auth()->user()->profile->id);

        return ReminderResource::make($reminders)->response()->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $reminder = $this->reminder->store($data);

        // return DefaultResource::make(['code' => 201, 'message' => 'Berhasil menambahkan pengingat'])->response()->setStatusCode(201);\
        return ReminderResource::make($reminder)->response()->setStatusCode(200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $reminder = $this->reminder->show($id);

        return ReminderResource::make($reminder)->response()->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $data = $request->validated();

        $reminder = $this->reminder->update($id, $data);

        // return DefaultResource::make(['code' => 200, 'message' => 'Berhasil mengubah pengingat'])->response()->setStatusCode(200);
        return ReminderResource::make($reminder)->response()->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reminder = $this->reminder->delete($id);

        if ($reminder != null) {
            // return DefaultResource::make(['code' => 200, 'message' => 'Berhasil menghapus pengingat'])->response()->setStatusCode(200);

            return ReminderResource::make($reminder)->response()->setStatusCode(200);
        }

        return DefaultResource::make(['code' => 500, 'message' => 'Gagal menghapus pengingat'])->response()->setStatusCode(500);
    }
}
