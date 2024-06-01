<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Contract;
use App\Models\RoomRental;

class CreateRoomRentalEntries extends Command
{
    protected $signature = 'create:roomrental';
    protected $description = 'Create room rental entries for contracts every 30 days';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $now = Carbon::now();
        $contracts = Contract::where('status', 'renting')->get();

        foreach ($contracts as $contract) {
            $startDate = Carbon::parse($contract->start_date);
            $diffInDays = $now->diffInDays($startDate);
            
            if ($diffInDays % 30 == 0) {
                RoomRental::create([
                    'room_id' => $contract->room_id,
                    'student_id' => $contract->student_id,
                    'status' => 'renting'
                ]);
            }
        }

        $this->info('Room rental entries have been created successfully.');
    }
}
