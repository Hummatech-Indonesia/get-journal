<?php

namespace App\Http\Controllers\Journal;

use App\Contracts\Interfaces\JournalInterface;
use App\Exports\JournalExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Journal\ExportRequest;
use App\Http\Requests\Journal\StoreRequest;
use App\Http\Requests\Journal\UpdateRequest;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\JournalResource;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelExcel;

class JournalController extends Controller
{
    private JournalInterface $journal;

    public function __construct(JournalInterface $journal)
    {
        $this->journal = $journal;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $journals = $this->journal->getJournalByUser(auth()->user()->profile->id);

        return JournalResource::make($journals)->response()->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $this->journal->store($data);

        return DefaultResource::make(['code' => 201, 'message' => 'Berhasil menambahkan jurnal'])->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $journal = $this->journal->show($id);

        return JournalResource::make($journal)->response()->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $data = $request->validated();

        $this->journal->update($id, $data);

        return DefaultResource::make(['code' => 200, 'message' => 'Berhasil memperbarui jurnal'])->response()->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = $this->journal->delete($id);

        if ($delete) {
            return DefaultResource::make(['code' => 200, 'message' => 'Berhasil menghapus jurnal'])->response()->setStatusCode(200);
        }

        return DefaultResource::make(['code' => 500, 'message' => 'Gagal menghapus jurnal'])->response()->setStatusCode(500);
    }

    /**
     * Export journal
     */
    public function export(ExportRequest $request)
    {
        $data = $request->validated();
        $journals = $this->journal->exportJournal($data['start_date'], $data['end_date'], $data['lesson_id']);

        $path = 'journals/' . date('His') . '-' . $data['filename'] . '.xlsx';
        $url =  Excel::store(new JournalExport($journals), $path, null, ExcelExcel::XLSX);

        return DefaultResource::make(['code' => 200, 'message' => 'Berhasil mengekspor jurnal', 'url' => $path])->response()->setStatusCode(200);
    }
}
