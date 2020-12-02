@foreach($profs as $prof)
    <div class="form-check">
        <label class="form-check-label">
            <input class="form-check-input" name="profs[]" value="{{ $prof->id }}" type="radio"
                @if ($prof->cours->contains('id', $cours->id)) checked @endif
            >
            {{ $prof->name }}
        </label>
    </div>
@endforeach
