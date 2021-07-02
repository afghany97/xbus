<?php

namespace App\Repositories;

use App\Models\Trip;
use Illuminate\Support\Facades\DB;

class TripRepository extends Repository
{
    /**
     * @inheritDoc
     */
    public function builder()
    {
        return Trip::query();
    }

    /**
     * @param int $tripId
     * @param int $startDestination
     * @return int|null
     */
    public function getOrderForStartDestination(int $tripId, int $startDestination): ?int
    {
        return $this->getOrderForDestination($tripId, $startDestination, "start");
    }

    /**
     * @param int $tripId
     * @param int $finalDestination
     * @return int|null
     */
    public function getOrderForFinalDestination(int $tripId, int $finalDestination): ?int
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
     * @param int $startOrder
     * @param int $finalOrder
     * @return int|null
     */
    public function getAvailableSeats(int $tripId, int $startOrder, int $finalOrder): ?int
    {
        return DB::table("trip_destinations")
            ->where("trip_id", $tripId)
            ->whereBetween("order", [$startOrder, $finalOrder])
            ->select([DB::raw("MAX(booked_seats_count) as booked_seats")])
            ->pluck("booked_seats")
            ->first();
    }
}
