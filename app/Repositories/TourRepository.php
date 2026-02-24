<?php

namespace App\Repositories;

use App\Models\Tour;
use App\Repositories\Contracts\TourRepositoryInterface;

class TourRepository implements TourRepositoryInterface
{
    protected $query;

    public function __construct()
    {
        $this->query = Tour::query();
    }

    public function all()
    {
        return $this->query->get();
    }

    public function with(array $relations)
    {
        $this->query->with($relations);
        return $this;
    }

    public function findBySlug($slug)
    {
        return $this->query->where('slug', $slug)->firstOrFail();
    }

    public function findById($id)
    {
        return Tour::findOrFail($id);
    }
}
