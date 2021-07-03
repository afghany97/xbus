<?php

namespace App\Repositories;

use App\Models\Booking;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookingRepository extends Repository
{
    /**
     * @var TripRepository
     */
    private $tripRepository;

    /**
     * BookingRepository constructor.
     */
    public function __construct(TripRepository $tripRepository)
    {
        $this->tripRepository = $tripRepository;
    }

    /**
     * @inheritDoc
     */
    protected function builder()
    {
        return Booking::query();
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
        try {
            $bookings = $this->prepareBookings($tripId, $startDestination, $finalDestination, $numberOfDemandSeats);
            DB::beginTransaction();
            $this->builder()->insert($bookings);
            $this->tripRepository->updateTripDestinations($tripId, $startDestination, $finalDestination, $numberOfDemandSeats);
            DB::commit();
            return array_column($bookings, "ticket");
        } catch (QueryException $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    /**
     * @param int $tripId
     * @param int $startDestination
     * @param int $finalDestination
     * @param int $numberOfDemandSeats
     * @return array
     */
    private function prepareBookings(int $tripId, int $startDestination, int $finalDestination, int $numberOfDemandSeats): array
    {
        $bookings = [];
        for ($i = 0; $i < $numberOfDemandSeats; $i++) {
            $bookings [] = [
                "trip_id" => $tripId,
                "start_destination_station_id" => $startDestination,
                "final_destination_station_id" => $finalDestination,
                "user_id" => auth()->id(),
                "ticket" => Str::random()
            ];
        }
        return $bookings;
    }
}
