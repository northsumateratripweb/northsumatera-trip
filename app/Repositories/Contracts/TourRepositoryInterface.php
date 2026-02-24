<?php

namespace App\Repositories\Contracts;

interface TourRepositoryInterface
{
    public function all();
    public function with(array $relations);
    public function findBySlug($slug);
    public function findById($id);
}
