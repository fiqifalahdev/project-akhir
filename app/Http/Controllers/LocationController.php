<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationRequest;
use App\Http\Utility\Location\Services\LocationServices;
use App\Models\Location;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LocationController extends Controller
{
    /**
     * Store location to database
     * 
     * @param LocationRequest $request
     * 
     * @return JsonResponse
     */
    public function storeLocation(LocationRequest $request): JsonResponse
    {

        try {
            // Validate request
            $request->validated();

            // Check if user already has location
            $userLocation = Location::where('user_id', auth()->id())->get();

            // Update location if user already has location
            if ($userLocation->isNotEmpty()) {
                $location = Location::where('user_id', auth()->id())->update([
                    'address' => $request->address,
                    'longitude' => $request->longitude,
                    'latitude' => $request->latitude,
                    'user_id' => auth()->id(),
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Location has been updated!',
                ], Response::HTTP_OK);
            }

            // Store location to database
            $location =  Location::create([
                'address' => $request->address,
                'longitude' => $request->longitude,
                'latitude' => $request->latitude,
                'user_id' => auth()->id(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Location has been saved!',
                'data' => $location
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to Save location : ' . $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
