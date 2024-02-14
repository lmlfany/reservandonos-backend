<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlaceDetail;
use Illuminate\Support\Facades\Http;
use App\Models\Place;


class PlaceDetailController extends Controller
{
    public function fetchInsert()
    {
        try {
            $places = Place::all();
            foreach ($places as $place) {

                if ($this->placeExists($place->id)) {

                    $response = Http::timeout(800)->get("https://dev.reservandonos.com/api/places/getPlaceById/{$place->id}");

                    if ($response->successful()) {
                        $placeDetails = $response->json();
                        if (isset($placeDetails['data'])) {
                            $this->savePlaceDetails($placeDetails['data']);
                        } else {
                            return response()->json(['error' => 'Data key "data" not found in the response'], 500);
                        }
                    } else {
                        return response()->json(['error' => 'Failed to fetch data from external API'], $response->status());
                    }
                }
            }
            return response()->json(['message' => 'All place details synchronized successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error occurred while fetching and inserting place details', 'details' => $e->getMessage()]);
        }
    }


    private function placeExists($placeId)
{
    return Place::where('id', $placeId)->exists();
}


    private function savePlaceDetails($placeDetails) {

        $existingPlaceDetail = PlaceDetail::where('place_id', $placeDetails['id'])->first();
        if ($existingPlaceDetail) {
            $existingPlaceDetail->update([
                'slug' => $placeDetails['slug'],
                'is_lite' => $placeDetails['is_lite'],
                'is_classic' => $placeDetails['is_classic'],
                'is_favorite' => $placeDetails['is_favorite'],
                'is_amex' => $placeDetails['is_amex'],
                'isOutstanding' => $placeDetails['isOutstanding'],
                'has_delivery' => $placeDetails['has_delivery'],
                'reservable' => $placeDetails['reservable'],
                'name' => $placeDetails['name'],
                'description' => $placeDetails['description'],
                'main_img' => $placeDetails['main_img'],
                'logo_img' => $placeDetails['logo_img'],
                'range_price' => $placeDetails['range_price'],
                'status' => $placeDetails['status'],
                'gallery' => isset($placeDetails['gallery']) ? json_encode($placeDetails['gallery']) : null,
                'schedules' => isset($placeDetails['schedules']) ? json_encode($placeDetails['schedules']) : null,
                'amenities' => isset($placeDetails['amenities']) ? json_encode($placeDetails['amenities']) : null,
            ]);

        } else  {
            $placeDetail = new PlaceDetail();
            $placeDetail->place_id = $placeDetails['id'];
            $placeDetail->slug = $placeDetails['slug'];
            $placeDetail->is_lite = $placeDetails['is_lite'];
            $placeDetail->is_classic = $placeDetails['is_classic'];
            $placeDetail->is_favorite = $placeDetails['is_favorite'];
            $placeDetail->is_amex = $placeDetails['is_amex'];
            $placeDetail->isOutstanding = $placeDetails['isOutstanding'];
            $placeDetail->has_delivery = $placeDetails['has_delivery'];
            $placeDetail->reservable = $placeDetails['reservable'];
            $placeDetail->name = $placeDetails['name'];
            $placeDetail->description = $placeDetails['description'];
            $placeDetail->main_img = $placeDetails['main_img'];
            $placeDetail->logo_img = $placeDetails['logo_img'];
            $placeDetail->range_price = $placeDetails['range_price'];
            $placeDetail->status = $placeDetails['status'];

            $placeDetail->gallery = isset($placeDetails['gallery']) ? json_encode($placeDetails['gallery']) : null;
            $placeDetail->schedules = isset($placeDetails['schedules']) ? json_encode($placeDetails['schedules']) : null;
            $placeDetail->amenities = isset($placeDetails['amenities']) ? json_encode($placeDetails['amenities']) : null;

            $placeDetail->save();
        }

    }


    public function show()
    {
     $placeDetails = PlaceDetail::all();
     return response()->json(['placeDetails' => $placeDetails]);
    }

public function showDetail($placeId)
{


    $placeDetails = PlaceDetail::where('place_id', $placeId)->first();

    if ($placeDetails) {
        return view('place-detail', ['placeId' => $placeId, 'placeDetails' => $placeDetails]);
    } else {
        return response()->json(['error' => 'Place details not found for place ID ' . $placeId], 404);
    }
}
}
