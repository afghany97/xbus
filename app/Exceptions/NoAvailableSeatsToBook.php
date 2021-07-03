<?php

namespace App\Exceptions;

use Exception;

class NoAvailableSeatsToBook extends Exception
{
    /**
     * NoAvailableSeatsToBook constructor.
     */
    public function __construct()
    {
        parent::__construct("There's no available seats to book");
    }
}
