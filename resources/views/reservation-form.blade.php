@extends('layouts.master')

@section('content')
    <div id="app">
        <v-app>
            <navbar></navbar>
            <reservation-form :place="{{ json_encode($place) }}" :place-detail="{{ json_encode($placeDetail) }}"></reservation-form>
        </v-app>
    </div>
@endsection

