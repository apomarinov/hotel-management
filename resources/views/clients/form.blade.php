@extends('layout.layout')

@section('content')
    <div class="columns is-centered">
        <div class="column is-7">
            <div class="box">
                <div class="column is-fullwidth has-text-centered"><strong class="is-size-3">Client</strong></div>
                <client-form :data="{{ $client }}"></client-form>
            </div>
        </div>
    </div>
@endsection
