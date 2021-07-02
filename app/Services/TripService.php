<?php

namespace App\Services;

use App\Exceptions\InvalidBookedSeats;
use App\Repositories\TripRepository;
use App\Utils\BusUtil;

class TripService extends Service
{
    /**
     * @var TripRepository
     */
    protected $repository;

    /**
     * TripService constructor.
     */
    public function __construct(TripRepository $tripRepository)
    {
        parent::__construct($tripRepository);
    }

    /**
     * @param int $tripId
     * @param int $startDestination
     * @param int $finalDestination
     * @return int
     * @throws InvalidBookedSeats
     */
    public function getAvailableSeats(int $tripId, int $startDestination, int $finalDestination): int
    {
        $startOrder = $this->repository->getOrderForStartDestination($tripId, $startDestination);
        $finalOrder = $this->repository->getOrderForFinalDestination($tripId, $finalDestination);

        $bookedSeats = $this->repository->getAvailableSeats($tripId, $startOrder, $finalOrder);
        if ($bookedSeats > BusUtil::MAX_CAPACITY) {
            throw new InvalidBookedSeats;
        }
        return BusUtil::MAX_CAPACITY - $bookedSeats;
    }
}
