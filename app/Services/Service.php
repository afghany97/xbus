<?php

namespace App\Services;

use App\Repositories\Repository;

abstract class Service
{
    /**
     * @var Repository
     */
    protected $repository;

    /**
     * Service constructor.
     */
    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }
}
