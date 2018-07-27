@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form action="{{ route('image.store', ['id' => 1]) }}" method="post" enctype="multipart/form-data">
                            <input multiple type="file" name="file[]" />
                            <button>send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
