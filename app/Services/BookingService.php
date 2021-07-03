<?php

namespace App\Services;

use App\Repositories\BookingRepository;

class BookingService extends Service
{
    /**
     * @var BookingRepository
     */
    protected $repository;

    /**
     * BookingService constructor.
     */
    public function __construct(BookingRepository $bookingRepository)
    {
        parent::__construct($bookingRepository);
    }

    /**
     * @param int $tripId
     * @param int $startDestination
     * @param int $finalDestination
     * @param int $numberOfDemandSeats
     * @return string[]
     */
    public function bookSeats(int $tripId, int $startDestination, int $finalDestination, int $numberOfDemandSeats): array
    {
        return $this->repository->bookSeats($tripId, $startDestination, $finalDestination, $numberOfDemandSeats);
    }
}
