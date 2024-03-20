<?php

namespace App\Contracts\Interfaces\Journal;

interface GetJournalByUserInterface
{
    public function getJournalByUser(mixed $id): mixed;
}
