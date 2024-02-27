<?php

namespace App\Console\Commands;

use App\Jobs\CalculateUserMaximumDiscountAllowed;
use App\Models\User;
use Illuminate\Console\Command;

class SyncDiscountToUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sfl:sync-discount-to-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::with(['permissions', 'roles'])->where('type','staff')->get();
        foreach ($users as $user) {
            CalculateUserMaximumDiscountAllowed::dispatch($user);
        }
    }
}
