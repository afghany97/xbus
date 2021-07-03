<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder as ORMBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

abstract class Repository
{
    /**
     * @return QueryBuilder|ORMBuilder
     */
    protected abstract function builder();
}
