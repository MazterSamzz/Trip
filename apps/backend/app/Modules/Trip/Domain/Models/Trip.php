<?php

namespace App\Modules\Trip\Domain\Models;

class Trip extends \App\Modules\Core\Domain\Models\BaseModel
{
    protected $table = 'trips';

    protected $fillable = [
        'title',
        'start_date',
    ];
}
