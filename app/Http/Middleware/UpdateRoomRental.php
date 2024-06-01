<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use App\Models\Contract;
use App\Models\RoomRental;
use Carbon\Carbon;

class UpdateRoomRental
{
    public function handle($request, Closure $next)
    {
        $this->updateRoomRentals();
        return $next($request);
    }

    protected function updateRoomRentals()
    {
        $contracts = Contract::where('status', 'renting')->get();
        $today = Carbon::today();

        foreach ($contracts as $contract) {
            $startDate = Carbon::parse($contract->start_date);
            $diffInDays = $startDate->diffInDays($today);

            if ($diffInDays % 30 == 0) {
                $exists = RoomRental::where('room_id', $contract->room_id)
                                    ->where('student_id', $contract->student_id)
                                    ->whereDate('created_at', $today)
                                    ->exists();

                if (!$exists) {
                    RoomRental::create([
                        'room_id' => $contract->room_id,
                        'student_id' => $contract->student_id,
                        'status' => 'renting'
                    ]);
                }
            }
        }
    }
}

