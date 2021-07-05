@error($field)
    <div class="alert alert-danger col-sm-12">
        <div class="alert alert-danger col-sm-12">
            @if (is_iterable($message))
                <ul>
                    @foreach($message as $indMessage)
                        <li>{{ $indMessage }}</li>
                    @endforeach
                </ul>
            @else
                {{ $message }}
            @endif
        </div>
    </div>
@enderror
