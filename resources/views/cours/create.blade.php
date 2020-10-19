@extends('layouts.form')
@section('card')
    @component('components.card')
        @slot('title')
            @lang('Ajouter un cours')
        @endslot
        <form method="POST" action="{{ route('cours.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group{{ $errors->has('cours') ? ' is-invalid' : '' }}">
                <div class="custom-file">
                    <input type="file" id="cours" name="image"
                           class="{{ $errors->has('cours') ? ' is-invalid ' : '' }}custom-file-input" required>
                    <label class="custom-file-label" for="cours"></label>
                    @if ($errors->has('image'))
                        <div class="invalid-feedback">
                            {{ $errors->first('image') }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <img id="preview" class="img-fluid" src="#" alt="">
            </div>
            <div class="form-group">
                <label for="matiere_id">@lang('Matière :')</label>
                <select id="matiere_id" name="matiere_id" class="form-control">
                    @foreach($matieres as $matiere)
                        <option value="{{ $matiere->id }}">{{ $matiere->name }}</option>
                    @endforeach
                </select>
            </div>
            @include('partials.form-group', [
                'title' => __('Description (optionnelle)'),
                'type' => 'text',
                'name' => 'description',
                'required' => false,
                ])
            @component('components.button')
                @lang('Envoyer')
            @endcomponent
        </form>
    @endcomponent
@endsection
@section('script')
    <script>
        $(() => {
            $('input[type="file"]').on('change', (e) => {
                let that = e.currentTarget
                if (that.files && that.files[0]) {
                    $(that).next('.custom-file-label').html(that.files[0].name)
                    let reader = new FileReader()
                    reader.onload = (e) => {
                        $('#preview').attr('src', e.target.result)
                    }
                    reader.readAsDataURL(that.files[0])
                }
            })
        })
    </script>
@endsection
