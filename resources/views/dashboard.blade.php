@extends('layouts.app')

@section('content')
    <div class="col-md-3">
        <bucket-menu v-bind:items="buckets"></bucket-menu>
    </div>
    <div class="col-md-3">
        <view-menu v-bind:items="views"></view-menu>
    </div>
    <div class="col-md-6">
        <view-form></view-form>
    </div>

    <form method="post" action="{{ route('bucket.store') }}">
        @csrf
        <label>
            <input name="name" type="text" />
        </label>
        <button>send</button>
    </form>
@endsection
