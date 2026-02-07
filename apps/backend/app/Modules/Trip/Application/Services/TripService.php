<?php

declare(strict_types=1);

namespace App\Modules\Trip\Application\Services;

use App\Modules\Trip\Domain\Models\Trip;
use Illuminate\Support\Facades\DB;

class TripService
{
    public function createTrip(array $data, int $ownerId): Trip
    {
        return DB::transaction(function () use ($data, $ownerId) {

            $trip = Trip::create([
                'title' => $data['title'],
                'start_date' => $data['start_date'],
            ]);

            $trip->owner_id = $ownerId;
            $trip->save();

            return $trip;
        });
    }
}
