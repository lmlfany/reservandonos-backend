@extends('layouts.master')

@section('content')
    <div id="app">
        <v-app>
            <navbar></navbar>
            <place-detail :place-id="{{ $placeId }}" :place-details="{{ json_encode($placeDetails) }}"></place-detail>
        </v-app>
    </div>
@endsection
