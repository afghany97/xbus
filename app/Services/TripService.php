<?php

namespace App\Services;

use App\Exceptions\InvalidBookedSeats;
use App\Exceptions\NoAvailableSeatsToBook;
use App\Repositories\TripRepository;
use App\Utils\BusUtil;

class TripService extends Service
{
    /**
     * @var TripRepository
     */
    protected $repository;

    /**
     * @var BookingService
     */
    private $bookingService;

    /**
     * TripService constructor.
     */
    public function __construct(TripRepository $tripRepository, BookingService $bookingService)
    {
        parent::__construct($tripRepository);
        $this->bookingService = $bookingService;
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
        $bookedSeats = $this->repository->getAvailableSeats($tripId, $startDestination, $finalDestination);
        if ($bookedSeats > BusUtil::MAX_CAPACITY) {
            throw new InvalidBookedSeats;
        }
        return BusUtil::MAX_CAPACITY - $bookedSeats;
    }

    /**
     * @param int $tripId
     * @param int $startDestination
     * @param int $finalDestination
     * @param int $numberOfDemandSeats
     * @return string[]
     * @throws InvalidBookedSeats
     * @throws NoAvailableSeatsToBook
     */
    public function bookSeats(int $tripId, int $startDestination, int $finalDestination, int $numberOfDemandSeats): array
    {
        $availableSeats = $this->getAvailableSeats($tripId, $startDestination, $finalDestination);

        if ($availableSeats < $numberOfDemandSeats) {
            throw new NoAvailableSeatsToBook;
        }
        return $this->bookingService->bookSeats($tripId, $startDestination, $finalDestination, $numberOfDemandSeats);
    }
}
