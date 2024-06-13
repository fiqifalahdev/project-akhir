<?php

namespace App\Http\Controllers;

use App\Models\FishMarket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;

class FishMarketController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('FishMarket', [
            'data' => FishMarket::orderBy('created_at', 'desc')->paginate(6)
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('FishMarketCreate');
    }

    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'address' => 'required|string',
                'phone' => 'required|string',
                'latitude' => 'required|string',
                'longitude' => 'required|string',
            ], [
                'name.required' => 'Name is required',
                'address.required' => 'Address is required',
                'phone.required' => 'Phone is required',
                'latitude.required' => 'Latitude is required',
                'longitude.required' => 'Longitude is required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('errors', $validator->errors()->first());
            }

            $create = FishMarket::create([
                'name' => $request->name,
                'address' => $request->address,
                'phone' => $request->phone,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);


            if (!$create) {
                return redirect()->back()->with('errors', 'Failed to create fish market');
            }
            return to_route('fish-market')->with('message', 'Fish market created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('errors', $e->getMessage());
        }
    }

    public function edit(Request $request)
    {
        $market = new FishMarket();
        $data = $market->find($request->id);

        return Inertia::render('FishMarketEdit', [
            'market' => $data
        ]);
    }

    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'address' => 'required|string',
                'phone' => 'required|string',
                'latitude' => 'required|string',
                'longitude' => 'required|string',
            ], [
                'name.required' => 'Name is required',
                'address.required' => 'Address is required',
                'phone.required' => 'Phone is required',
                'latitude.required' => 'Latitude is required',
                'longitude.required' => 'Longitude is required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('errors', $validator->errors()->first());
            }

            $market = new FishMarket();
            $update = $market->find($request->id)->update([
                'name' => $request->name,
                'address' => $request->address,
                'phone' => $request->phone,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);

            if (!$update) {
                return redirect()->back()->with('errors', 'Failed to update fish market');
            }
            return to_route('fish-market')->with('message', 'Fish market updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {


            $market = new FishMarket();
            $market->find($request->id)->delete();

            return redirect()->back()->with('message', 'Fish market deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
