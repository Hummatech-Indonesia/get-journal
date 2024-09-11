<?php

namespace App\Console\Commands;

use App\Contracts\Interfaces\User\ProfileInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckPremiumCommand extends Command
{
    private ProfileInterface $profile;

    public function __construct(ProfileInterface $profile)
    {
        parent::__construct();
        $this->profile = $profile;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-premium';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check premium user has expired or not';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = $this->profile->getDataHasExpiredPremium();
        Log::info($users);
        if(count($users) > 0){
            foreach($users as $user){
                // Menyisakan 2 kelas yang terlama dibikin
                if(count($user->classrooms) > 2) {
                    unset($user->classrooms[0]);
                    unset($user->classrooms[1]);
                }

                $user->update([
                    'premium_expired_at' => null,
                    "is_premium" => 0,
                    "is_premium_private" => 0,
                    "is_premium_school" => 0,
                    "user_premium_private_id" => null,
                    "user_premium_school_id" => null
                ]);

                // Update kelas menjadi terkunci
                foreach($user->classrooms as $class){
                    $class->update(['is_locked' => 1]);
                }
            }
        }
    }
}
