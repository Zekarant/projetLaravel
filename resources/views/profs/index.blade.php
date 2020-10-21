@extends('layouts.form')
@section('card')
    @component('components.card')
        @slot('title')
            @lang('Gestion des professeurs')
        @endslot
        <table class="table table-dark text-white">
            <tbody>
            @if($profs->isEmpty())
                <p class="text-center">@lang("Vous n'avez aucun professeur recensé pour le moment")</p>
            @else
                @foreach($profs as $prof)
                    <tr>
                        <td>{{ $prof->name }}</td>
                        <td>
                            <a type="button" href="{{ route('prof.destroy', $prof->id) }}"
                               class="btn btn-danger btn-sm pull-right invisible" data-toggle="tooltip"
                               title="@lang("Supprimer le professeur") {{ $prof->name }}"><i
                                    class="fas fa-trash fa-lg"></i></a>
                            <a type="button" href="{{ route('prof.edit', $prof->id) }}"
                               class="btn btn-warning btn-sm pull-right mr-2 invisible" data-toggle="tooltip"
                               title="@lang("Modifier le professeur") {{ $prof->name }}"><i
                                    class="fas fa-edit fa-lg"></i></a>
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    @endcomponent
@endsection
@section('script')
    <script>
        $(() => {
            $('a').removeClass('invisible')
        })
    </script>
    @include('partials.script-delete', ['text' => __('Vraiment supprimer cet professeur ?'), 'return' => 'removeTr'])
@endsection
