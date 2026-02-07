<?php

namespace App\Modules\Trip\Infrastructure\Repositories;

use App\Modules\Trip\Domain\Models\Trip;
use App\Modules\Core\Infrastructure\Repositories\BaseRepository;

class TripRepository extends BaseRepository
{
    public function __construct(Trip $model)
    {
        parent::__construct($model);
    }
}
