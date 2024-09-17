<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\JournalInterface;
use App\Models\Journal;
use Illuminate\Support\Facades\Storage;

class JournalRepository extends BaseRepository implements JournalInterface
{
    public function __construct(Journal $model)
    {
        $this->model = $model;
    }

    /*
    * Get journal by user
    *
    * @param mixed $id
    * @return mixed
    */
    public function getJournalByUser(mixed $id): mixed
    {
        return $this->model->with('sick.profile', 'permit.profile', 'alpha.profile', 'classroom')
        ->where('profile_id', $id)
        ->orderBy('date','DESC')
        ->get();
    }

    /*
    * Get journal by classroom
    *
    * @param mixed $classroom_id
    * @return mixed
    */
    public function getJournalByClassroom(mixed $classroom_id): mixed
    {
        return $this->model
            ->with('classroom')
            ->where('classroom_id', $classroom_id)
            ->get();
    }

    /*
    * Show journal
    *
    * @param mixed $id
    * @return mixed
    */
    public function show(mixed $id): mixed
    {
        return $this->model->with('sick.profile', 'permit.profile', 'alpha.profile', 'lesson.classroom')->find($id);
    }

    /*
    * Store journal
    *
    * @param array $data
    * @return mixed
    */
    public function store(array $data): mixed
    {
        $journal = $this->model->create($data);
        (array_key_exists('sick', $data)) ? $journal->attendances()->createMany($data['sick']) : null;
        (array_key_exists('permit', $data)) ? $journal->attendances()->createMany($data['permit']) : null;
        (array_key_exists('alpha', $data)) ? $journal->attendances()->createMany($data['alpha']) : null;

        return $journal;
    }

    /*
    * Update journal
    *
    * @param mixed $id
    * @param array $data
    * @return mixed
    */
    public function update(mixed $id, array $data): mixed
    {
        $journal = $this->model->find($id);
        $journal->update($data);
        $journal->attendances()->delete();

        (array_key_exists('sick', $data)) ? $journal->attendances()->createMany($data['sick']) : null;
        (array_key_exists('permit', $data)) ? $journal->attendances()->createMany($data['permit']) : null;
        (array_key_exists('alpha', $data)) ? $journal->attendances()->createMany($data['alpha']) : null;

        return $journal;
    }

    /*
    * Delete journal
    *
    * @param mixed $id
    * @return mixed
    */
    public function delete(mixed $id): mixed
    {
        try {
            $this->model->destroy($id);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Export journal
     * 
     * @param mixed $startSate
     * @param mixed $endDate
     * 
     * @return mixed
     */
    public function exportJournal(mixed $startSate, mixed $endDate, mixed $classroomId): mixed
    {
        return $this->model
            ->with('classroom', 'lesson', 'sick.profile', 'permit.profile', 'alpha.profile')
            ->whereBetween('date', [$startSate, $endDate])
            ->where('classroom_id', $classroomId)
            ->orderBy('lesson_id', 'asc')
            ->get();
    }

    /**
     * Delete export journal
     * 
     * @param mixed $path
     * 
     * @return mixed
     */
    public function deleteExportJournal(mixed $path): mixed
    {
        if (Storage::exists($path))
            return Storage::delete($path);

        return null;
    }
}
