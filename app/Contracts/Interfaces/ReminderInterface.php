<?php

namespace App\Contracts\Interfaces;

use App\Contracts\Interfaces\Eloquent\DeleteInterface;
use App\Contracts\Interfaces\Eloquent\ShowInterface;
use App\Contracts\Interfaces\Eloquent\StoreInterface;
use App\Contracts\Interfaces\Eloquent\UpdateInterface;
use App\Contracts\Interfaces\Reminder\GetReminderByUserInterface;

interface ReminderInterface extends GetReminderByUserInterface, StoreInterface, UpdateInterface, DeleteInterface, ShowInterface
{
}
