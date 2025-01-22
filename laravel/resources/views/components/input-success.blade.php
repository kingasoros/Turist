
@props(['messages'])

@if ($messages)
    <div class="text-green-500 mt-2">
        <ul>
            @foreach ((array) $messages as $message)
                <li>
                    <div class="success-message mt-2">
                        {{ $messages }}
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endif
<style>
    /* Példa a CSS fájlhoz */
    .success-message {
        color: green;
    }
</style>