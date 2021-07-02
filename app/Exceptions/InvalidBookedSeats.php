<?php

namespace App\Exceptions;

use Exception;

class InvalidBookedSeats extends Exception
{
    /**
     * InvalidBookedSeats constructor.
     */
    public function __construct()
    {
        parent::__construct("Invalid Booked Seats");
    }
}
