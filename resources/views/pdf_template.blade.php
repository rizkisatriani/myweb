@foreach($images as $index => $src)
    <div style="margin: {{ $margin === 'small' ? '20px' : ($margin === 'large' ? '60px' : '0') }};
                {{ $index < count($images) - 1 ? 'page-break-after: always;' : '' }}">
        <img src="{{ $src }}" style="width: 100%; height: auto;">
    </div>
@endforeach