@extends('layouts.form-wide')

@section('css')

    <style>
        .fa-check { color: green; }
    </style>

@endsection


@section('card')

    @component('components.card')

        @slot('title')
            @lang('Gestion des utilisateurs (administrateurs en rouge)')
        @endslot

        <div class="table-responsive">
            <table class="table table-dark text-white">
                <thead>
                <tr>
                    <th scope="col">@lang("Grade")</th>
                    <th scope="col">@lang('Nom')</th>
                    <th scope="col">@lang('Email')</th>
                    <th scope="col">@lang('Inscription')</th>
                    <th scope="col">@lang('Cours')</th>
                    <th>Modifier</th>
                    <th>Supprimer</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>
                            @if($user->admin)
                                <span class="badge badge-danger">Admin</span>
                            @else
                                <span class="badge badge-primary">Utilisateur</span>
                            @endif
                        </td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at->formatLocalized('%x') }}</td>
                        <td>{{ $user->cours_count }}</td>
                        <td>
                            <a type="button" href="{{ route('user.edit', $user->id) }}"
                               class="btn btn-warning btn-sm pull-right"><i
                                    class="fas fa-edit fa-lg"></i></a>
                        </td>
                        <td>
                            @unless($user->admin)
                                <a type="button" href="{{ route('user.destroy', $user->id) }}"
                                   class="btn btn-danger btn-sm pull-right invisible"><i
                                        class="fas fa-trash fa-lg"></i></a>
                            @endunless
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    @endcomponent

@endsection

@section('script')

    <script>
        $(() => {
            $('a').removeClass('invisible')
        })
    </script>

    @include('partials.script-delete', ['text' => __('Vraiment supprimer cet utilisateur ?'), 'return' => 'removeTr'])

@endsection
