<?php

declare(strict_types=1);

namespace App\Modules\Trip\Presentation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Trip\Presentation\Http\Requests\StoreTripRequest as StoreRequest;
use App\Modules\Trip\Domain\Models\Trip;
use Illuminate\Http\RedirectResponse;

class TripController extends Controller
{
    public function store(StoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $trip = Trip::create([
            'user_id'    => $request->user()->id,
            'title'      => $data['title'],
            'start_date' => $data['start_date'],
        ]);

        return redirect()
            ->route('trips.show', $trip)
            ->with('success', 'Trip berhasil dibuat');
    }
}
