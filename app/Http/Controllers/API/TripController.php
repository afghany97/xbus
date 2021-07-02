<?php

namespace App\Http\Controllers\API;

use App\Exceptions\InvalidBookedSeats;
use App\Services\TripService;
use App\Utils\HttpStatusCodeUtil;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class TripController extends ApiController
{
    /**
     * @var TripService
     */
    protected $service;

    /**
     * TripController constructor.
     */
    public function __construct(TripService $tripService)
    {
        parent::__construct($tripService);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function search(int $id, Request $request): JsonResponse
    {
        try {
            $validatedData = $this->validateTripSearchRequest($request, $id);
            $availableSeats = $this->service->getAvailableSeats($id, $validatedData["start_destination"], $validatedData["final_destination"]);
            $payload = [
                "availableSeats" => $availableSeats
            ];
            return $this->response($payload, HttpStatusCodeUtil::OK);
        } catch (ValidationException $exception) {
            $payload = [
                "errors" => [
                    "message" => $exception->errors()
                ]
            ];
            return $this->response($payload, HttpStatusCodeUtil::INTERNAL_SERVER_ERROR);
        } catch (InvalidBookedSeats $exception) {
            Log::error($exception->getMessage(), compact("exception"));
            $payload = [
                "errors" => [
                    "message" => "there's no seats available"
                ]
            ];
            return $this->response($payload, HttpStatusCodeUtil::INTERNAL_SERVER_ERROR);
        } catch (QueryException | Exception $exception) {
            Log::error($exception->getMessage(), compact("exception"));
            $payload = [
                "errors" => [
                    "message" => $exception->getMessage()
                ]
            ];
            return $this->response($payload, HttpStatusCodeUtil::INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param Request $request
     * @param int $tripId
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    private function validateTripSearchRequest(Request $request, int $tripId): array
    {
        return $this->validate($request, [
            "start_destination" => [
                "required",
                "int",
                Rule::exists("trip_destinations", "start_destination_station_id")
                    ->where("trip_id", $tripId)
            ],
            "final_destination" => [
                "required",
                "int",
                Rule::exists("trip_destinations", "final_destination_station_id")
                    ->where("trip_id", $tripId)
            ]
        ]);
    }
}
