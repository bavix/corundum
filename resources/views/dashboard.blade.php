@extends('layouts.app')

@section('content')
    <div class="col-md-3">
        <bucket-form></bucket-form>
        <bucket-menu v-bind:items="buckets"></bucket-menu>

        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#bucketFormModal">
            Add bucket
        </button>
    </div>
    <div class="col-md-3">
        <view-menu v-bind:items="views"></view-menu>
    </div>
    <div class="col-md-6">
        <view-form></view-form>
    </div>
@endsection
