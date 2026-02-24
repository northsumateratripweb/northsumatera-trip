<?php

namespace App\Repositories;

use App\Models\Car;
use App\Repositories\Contracts\CarRepositoryInterface;

class CarRepository implements CarRepositoryInterface
{
    public function getAvailable()
    {
        return Car::where('is_available', true)->get();
    }
}
