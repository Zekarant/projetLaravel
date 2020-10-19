@extends('layouts.app')

@section('content')

    <div class="site-wrapper">
        <div class="site-wrapper-inner text-white text-center">
            <i class="fas fa-spinner fa-pulse fa-4x"></i>
        </div>
    </div>

    <main class="container-fluid">
        @if(session('updated'))
            <div class="alert alert-dark" role="alert">
                {{ session('updated') }}
            </div>
        @endif
        @isset($matiere)
            <h2 class="text-title mb-3">{{ $matiere->name }}</h2>
        @endif
        @isset($user)
            <h2 class="text-title mb-3">{{ __('Cours de ') . $user->name }}</h2>
        @endif
        <div class="d-flex justify-content-center">
            {{ $cours->links() }}
        </div>
        <div class="card-columns">
            @foreach($cours as $cour)
                <div class="card" id="cours{{ $cour->id }}">
                    <a href="{{ url('storage/' . $cour->name) }}" class="cour-link">
                        <img class="card-img-top"
                             src="{{ url('storage/' . $cour->name) }}"
                             alt="cours" width="250" height="200">
                    </a>
                    @isset($cour->description)
                        <div class="card-body">
                            <p class="card-text">{{ $cour->description }}</p>
                        </div>
                    @endisset
                    <div class="card-footer text-muted">
                        <em>
                            <a href="{{ route('user', $cour->user->id) }}" data-toggle="tooltip"
                               title="{{ __('Voir les cours de ') . $cour->user->name }}">{{ $cour->user->name }}</a>
                        </em>
                        <div class="pull-right">
                            <em>
                                {{ $cour->created_at->formatLocalized('%x') }}
                            </em>
                        </div>


                        <div class="star-rating" id="{{ $cour->id }}">
                            <span class="pull-right">
                                @adminOrOwner($cour->user_id)
                                    <a class="toggleIcons"
                                       href="#">
                                    <i class="fa fa-cog"></i>
                                    </a>
                                    <span class="menuIcons" style="display: none">
                                        <a class="form-delete text-danger"
                                           href="{{ route('cours.destroy', $cour->id) }}"
                                           data-toggle="tooltip"
                                           title="@lang('Supprimer cette photo')">
                                           <i class="fa fa-trash"></i>
                                        </a>
                                        <a class="description-manage"
                                           href="{{ route('cours.description', $cour->id) }}"
                                           data-toggle="tooltip"
                                           title="@lang('Gérer la description')">
                                           <i class="fa fa-comment"></i>
                                        </a>
                                        <a class="matiere-edit"
                                           data-id="{{ $cour->matiere_id }}"
                                           href="{{ route('cours.update', $cour->id) }}"
                                           data-toggle="tooltip"
                                           title="@lang('Changer de matière')">
                                           <i class="fa fa-edit"></i>
                                        </a>
                                    </span>
                                    <form action="{{ route('cours.destroy', $cour->id) }}" method="POST" class="hide">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @endadminOrOwner
                            </span>
                        </div>


                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center">
            {{ $cours->links() }}
        </div>
    </main>

    <div class="modal fade" id="changeDescription" tabindex="-1" role="dialog" aria-labelledby="descriptionLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="descriptionLabel">@lang('Changement de la description')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="descriptionForm" action="" method="POST">
                        <div class="form-group">
                            <input type="text" class="form-control" name="description" id="description">
                            <small class="invalid-feedback"></small>
                        </div>
                        <button type="submit" class="btn btn-primary">@lang('Envoyer')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="changeMatiere" tabindex="-1" role="dialog" aria-labelledby="matiereLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="matiereLabel">@lang('Changement de la matière')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" action="" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <select class="form-control" name="matiere_id">
                                @foreach($matieres as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">@lang('Envoyer')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

    <script>
        $(() => {

            const swallAlertServer = () => {
                swal.fire({
                    title: '@lang('Il semble y avoir une erreur sur le serveur, veuillez réessayer plus tard...')',
                    icon: 'warning'
                })
            }

            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            })

            $('.site-wrapper').fadeOut(1000)

            $('[data-toggle="tooltip"]').tooltip()

            $('a.toggleIcons').click((e) => {
                e.preventDefault();
                let that = $(e.currentTarget)
                that.next().toggle('slow').end().children().toggleClass('fa-cog').toggleClass('fa-play')
            })

            $('a.form-delete').click((e) => {
                e.preventDefault();
                let href = $(e.currentTarget).attr('href')
                swal.fire({
                    title: '@lang('Vraiment supprimer cette photo ?')',
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: '@lang('Oui')',
                    cancelButtonText: '@lang('Non')'
                }).then((result) => {
                    if (result.value) {
                        $("form[action='" + href + "'").submit()
                    }
                })
            })

            $('a.description-manage').click((e) => {
                e.preventDefault()
                let that = $(e.currentTarget)
                let text = that.parents('.card').find('.card-text').text()
                $('#description').val(text)
                $('#descriptionForm').attr('action', that.attr('href')).find('input').removeClass('is-invalid').next().text()
                $('#changeDescription').modal('show')
            })

            $('#descriptionForm').submit((e) => {
                e.preventDefault()
                let that = $(e.currentTarget)
                $.ajax({
                    method: 'put',
                    url: that.attr('action'),
                    data: that.serialize()
                })
                    .done((data) => {
                        let card = $('#cours' + data.id)
                        let body = card.find('.card-body')
                        if(body.length) {
                            body.children().text(data.description)
                        } else {
                            card.children('a').after('<div class="card-body"><p class="card-text">' + data.description + '</p></div>')
                        }
                        $('#changeDescription').modal('hide')
                    })
                    .fail((data) => {
                        if(data.status === 422) {
                            $.each(data.responseJSON.errors, function (key, value) {
                                $('#descriptionForm input[name=' + key + ']').addClass('is-invalid').next().text(value)
                            })
                        } else {
                            swallAlertServer()
                        }
                    })
            })

            $('a.matiere-edit').click((e) => {
                e.preventDefault()
                let that = $(e.currentTarget)
                $('select').val(that.attr('data-id'))
                $('#editForm').attr('action', that.attr('href'))
                $('#changeMatiere').modal('show')
            })

        })
    </script>
@endsection
