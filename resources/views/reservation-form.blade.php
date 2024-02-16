@extends('layouts.master')

@section('content')
    <div id="app">
        <v-app>
            <navbar></navbar>
            <reservation-form :placeId="{{ json_encode($placeId) }}"></reservation-form>
        </v-app>
    </div>
@endsection

