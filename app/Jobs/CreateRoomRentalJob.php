<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Contract;
use App\Models\RoomRental;
use Carbon\Carbon;

class CreateRoomRentalJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $contracts = Contract::where('status', 'renting')->get();

        foreach ($contracts as $contract) {
            $startDate = Carbon::parse($contract->start_date);
            $now = Carbon::now();
            if ($now->diffInDays($startDate) >= 3) {
                RoomRental::create([
                    'room_id' => $contract->room_id,
                    'student_id' => $contract->student_id,
                    'status' => 'renting',
                ]);
            }
        }
    }
}
