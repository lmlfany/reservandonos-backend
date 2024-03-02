<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Place;
use Illuminate\Support\Facades\Http;

class PlaceController extends Controller
{   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function fetchInsert()
   {

    $perPage = 30;
    $maxPages = 3;

    for ($page = 0; $page < $maxPages; $page++) {

        //API
        $response = Http::get('https://dev.reservandonos.com/api/places/getPlacesByFilter', [
         'mode' => 'web',
         'page' => $page,
         'perPage' => $perPage,
     ]);

     if ($response->successful()) {
         $places = $response->json()['data'];

         if (empty($places)) {
            break;
        }

         foreach($places as $placeData){

            $existingPlace = Place::where('url', $placeData['url'])->first();
            $existingPlace = Place::where('id', $placeData['id'])->first();

            if ($existingPlace) {
                $placeData['url'] = $placeData['url'] . '_' . uniqid();
            } else  {

                $place = new Place();
                $place->id = $placeData['id'];
                $place->url = $placeData['url'];
                $place->is_favorite = $placeData['is_favorite'];
                $place->is_lite = $placeData['is_lite'];
                $place->is_classic = $placeData['is_classic'];
                $place->is_amex = $placeData['is_amex'];
                $place->has_delivery = $placeData['has_delivery'];
                $place->image_url = $placeData['image_url'];
                $place->logo_url = $placeData['logo_url'];
                $place->name = $placeData['name'];
                $place->shortName = $placeData['shortName'];
                $place->main_category = $placeData['main_category'];
                $place->categories = $placeData['categories'] ?? 'Sin categoría';
                $place->schedule = $placeData['schedule'];
                $place->score = $placeData['score'];
                $place->price_range = $placeData['price_range'];
                $place->location = $placeData['location'];
                $place->position = json_encode($placeData['position']);
                $place->isOutstanding = $placeData['isOutstanding'];
                $place->save();
            }

         }

        } else {
            return response()->json(['error' => 'Failed to fetch data from external API'], $response->status());
        }
    }
            return response()->json(['message' => 'Places synchronized successfully']);
    }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
       //
   }

   /**
    * Display the specified resource.
    *
    * @param  \App\Models\Place  $place
    * @return \Illuminate\Http\Response
    */
   public function show()
   {
    $places = Place::all();
    return response()->json(['places' => $places]);
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Models\Place  $place
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, Place $place)
   {

   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Models\Place  $place
    * @return \Illuminate\Http\Response
    */
   public function destroy(Place $place)
   {
       //
   }
}
