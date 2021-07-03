<?php

namespace App\Repositories;

use App\Models\Trip;
use Illuminate\Support\Facades\DB;

class TripRepository extends Repository
{
    /**
     * @inheritDoc
     */
    protected function builder()
    {
        return Trip::query();
    }

    /**
     * @param int $tripId
     * @param int $startDestination
     * @return int|null
     */
    private function getOrderForStartDestination(int $tripId, int $startDestination): ?int
    {
        return $this->getOrderForDestination($tripId, $startDestination, "start");
    }

    /**
     * @param int $tripId
     * @param int $finalDestination
     * @return int|null
     */
    private function getOrderForFinalDestination(int $tripId, int $finalDestination): ?int
    {
        return $this->getOrderForDestination($tripId, $finalDestination, "final");
    }

    /**
     * @param int $tripId
     * @param int $destinationId
     * @param string $destination
     * @return int|null
     */
    private function getOrderForDestination(int $tripId, int $destinationId, string $destination): ?int
    {
        $column = $destination == "final" ? "final_destination_station_id" : "start_destination_station_id";
        return DB::table("trip_destinations")
            ->where("trip_id", $tripId)
            ->where($column, $destinationId)
            ->select(["order"])
            ->pluck("order")
            ->first();
    }

    /**
     * @param int $tripId
     * @param int $startDestination
     * @param int $finalDestination
     * @return int|null
     */
    public function getAvailableSeats(int $tripId, int $startDestination, int $finalDestination): ?int
    {
        return DB::table("trip_destinations")
            ->where("trip_id", $tripId)
            ->whereBetween("order", [$this->getOrderForStartDestination($tripId, $startDestination), $this->getOrderForFinalDestination($tripId, $finalDestination)])
            ->select([DB::raw("MAX(booked_seats_count) as booked_seats")])
            ->pluck("booked_seats")
            ->first();
    }

    /**
     * @param int $tripId
     * @param int $startDestination
     * @param int $finalDestination
     * @param int $numberOfDemandSeats
     * @return int
     */
    public function updateTripDestinations(int $tripId, int $startDestination, int $finalDestination, int $numberOfDemandSeats): int
    {
        return DB::table("trip_destinations")
            ->where("trip_id", $tripId)
            ->whereBetween("order", [$this->getOrderForStartDestination($tripId, $startDestination), $this->getOrderForFinalDestination($tripId, $finalDestination)])
            ->increment("booked_seats_count", $numberOfDemandSeats);
    }

}
