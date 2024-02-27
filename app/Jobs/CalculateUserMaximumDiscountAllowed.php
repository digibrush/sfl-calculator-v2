<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CalculateUserMaximumDiscountAllowed implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = $this->user;
        $discountArr = array();
        foreach ($user->roles as $role) {
            foreach ($role->permissions as $permission) {
                if (str_contains($permission->name, 'Discount upto')) {
                    array_push($discountArr, (float)explode('-',$permission->name)[1]);
                }
            }
        }
        $maxDiscount = max($discountArr);
        $user->update([
            'discount_rate' => $maxDiscount
        ]);
    }
}
