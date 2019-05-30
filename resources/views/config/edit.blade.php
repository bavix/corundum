<form method="post" action="{{ route('ux.config.store') }}">

    {{ csrf_field() }}

    @if (isset($item))
        <input type="hidden" name="id" value="{{ $item->id }}" />
    @endif

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="{{ old('name', $item->name ?? null) }}">
    </div>

    <div class="form-group">
        <label for="type">Type</label>
        <select class="form-control" name="type" id="type">
            @php($type = old('type', $item->type ?? null))
            @foreach(\App\Enums\Image\ImageViewsEnum::enums() as $enum)
                <option name="{{ $enum }}" @if($type === $enum)selected @endif>{{ $enum }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="width">Width</label>
        <input type="number" class="form-control" name="width" id="width" placeholder="300"
               value="{{ old('width', $item->width ?? null) }}">
    </div>
    <div class="form-group">
        <label for="height">Height</label>
        <input type="number" class="form-control" name="height" id="height" placeholder="300"
               value="{{ old('height', $item->height ?? null) }}">
    </div>

    <div class="form-group">
        <label for="color">Color</label>
        <input type="text" class="form-control" name="color" id="color" placeholder="#fdf400"
               value="{{ old('color', $item->color ?? null) }}">
    </div>

    <div class="form-group">
        <label for="quality">Quality</label>
        <input type="number" max="100" min="1" class="form-control" name="quality" id="quality"
               placeholder="97" value="{{ old('quality', $item->quality ?? null) }}">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>

</form>
