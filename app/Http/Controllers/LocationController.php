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


    /**
     * Get User location with calculating nearest location with others users
     * in this function im using a Haversine algorithm to calculate the distance between two points
     * 
     * @return JsonResponse
     * 
     * Expected response
     * [
     *      {
     *          userId: xx, 
     *          coordinates: LatLng(lat, long)
     *      }, 
     *      
     *      ... etc
     * ];
     * 
     */

    public function getUserLocation(): JsonResponse
    {
        try {
            // Get all user location
            $locations = Location::where('user_id', '!=', auth()->id())->get()->toArray();

            // Get current user location
            $currentUserLocation = Location::where('user_id', auth()->id())->first()->toArray();

            $nearestLocation = [];

            foreach ($locations as $location) {
                $distances = $this->haversineCalc(['longitude' => $currentUserLocation['longitude'], 'latitude' => $currentUserLocation['latitude']], ['longitude' => $location['longitude'], 'latitude' => $location['latitude']]);

                if ($distances <= 5) {
                    $nearestLocation[] = [
                        'userId' => $location['user_id'],
                        'coordinates' => [
                            'latitude' => $location['latitude'],
                            'longitude' => $location['longitude']
                        ],
                        'distance' => $distances
                    ];
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Near User location',
                'data' => $nearestLocation
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get user location : ' . $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getTargetLocation(Request $request)
    {
        try {
            $location = Location::where('user_id', $request->user_id)->first();

            if ($location == null) {
                return response()->json([
                    'success' => false,
                    'message' => 'User location not found'
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'success' => true,
                'message' => 'User location found',
                'data' => [
                    'latitude' => $location->latitude,
                    'longitude' => $location->longitude,
                    'address' => $location->address
                ]
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get target location : ' . $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getCurrentLocation(): JsonResponse
    {
        try {
            $location = Location::where('user_id', auth()->id())->first();

            if ($location == null) {
                return response()->json([
                    'success' => false,
                    'message' => 'User location not found'
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'success' => true,
                'message' => 'User location found',
                'data' => [
                    'latitude' => $location->latitude,
                    'longitude' => $location->longitude,
                    'address' => $location->address
                ]
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get current location : ' . $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    protected function haversineCalc(array $longlat1, array $longlat2) // ini nanti harus dimasukkan ke buku PA
    {

        $R = 6371; // Radius of the earth in km
        $dLat = deg2rad($longlat2['latitude'] - $longlat1['latitude']);  // deg2rad below
        $dLon = deg2rad($longlat2['longitude'] - $longlat1['longitude']);

        $a =
            sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($longlat1['latitude'])) * cos(deg2rad($longlat2['latitude'])) *
            sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $d = $R * $c; // Distance in km
        return $d;
    }
}
