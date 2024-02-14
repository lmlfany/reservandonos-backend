@extends('layouts.master')

@section('content')
    <div id="app">
        <v-app>
            <navbar></navbar>
            <v-container fluid>
                <place-detail :place-id="{{ $placeId }}" :place-details="{{ json_encode($placeDetails) }}"></place-detail>
            </v-container>
        </v-app>
    </div>
@endsection
