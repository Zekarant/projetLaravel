@extends('layouts.app')
@section('content')
    <main class="container-fluid">
        <h1>
            {{ $orphans->count }} {{ trans_choice(__('image orpheline|images orphelines'), $orphans->count) }}
            @if($orphans->count)
                <a class="btn btn-danger pull-right" href="{{ route('orphans.destroy') }}"
                   role="button">@lang('Supprimer')</a>
            @endif
        </h1>
        <div class="card-columns">
            @foreach($orphans as $orphan)
                <div class="card">
                    <?php dump($orphan); ?>
                    <img class="img-fluid" src="{{ asset('storage/cours/images/' . $orphan) }}" alt="image">
                </div>
            @endforeach
        </div>
    </main>
@endsection
@section('script')
    @include('partials.script-delete', ['text' => __('Vraiment supprimer toutes les photos orphelines ?'), 'return' => 'reload'])
@endsection
