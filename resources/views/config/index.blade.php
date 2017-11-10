@extends('layouts.app')

@section('content')
    <div class="row">

        <div class="col-8">
            <a href="{{ route('ux.config.create') }}" class="btn btn-success btn-sm float-right">+</a>
            <h1>Configs</h1>

            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Width</th>
                        <th>Height</th>
                        <th>Color</th>
                        <th>Quality</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user->configs as $config)
                        <tr>
                            <td>{{ $config->id }}</td>
                            <td>{{ $config->name }}</td>
                            <td>{{ $config->type }}</td>
                            <td>{{ $config->width }}</td>
                            <td>{{ $config->height }}</td>
                            <td>
                                @if ($config->color)
                                    <div class="badge" style="background: {{ $config->color }}">C</div>
                                @else
                                    null
                                @endif
                            </td>
                            <td>
                                @if ($config->quality)
                                    {{ $config->quality }}%
                                @else
                                    100%
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-sm btn-primary" href="{{ route('ux.config.edit', [$config->id]) }}">edit</a>
                                <a class="btn btn-sm btn-danger" href="#" data-destroy="{{ route('ux.config.destroy', [$config->id]) }}">delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="col-4">
            @include('config.edit')
        </div>

    </div>
@endsection
