<?php

namespace App\Contracts\Interfaces\Reminder;

interface GetReminderByUserInterface
{
    public function getReminderByUser(mixed $userId): mixed;
}
