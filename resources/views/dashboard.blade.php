@extends('layouts.app')

@section('content')
    <div class="col-md-3">
        <bucket-menu v-bind:items="buckets"></bucket-menu>
    </div>
    <div class="col-md-3">
        <view-menu v-bind:items="buckets"></view-menu>
    </div>
    <div class="col-md-6">
        <view-form v-bind:items="buckets"></view-form>
    </div>
@endsection
