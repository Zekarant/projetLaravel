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
            @isset($prof)
                <h2 class="text-title mb-3">Cours de {{ $prof->name }}</h2>
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
                        <a href="{{ $cour->lien }}"><img class="card-img-top"
                             src="{{ url('storage/' . $cour->name) }}"
                                        alt="cours" width="250" height="200"></a>
                    @isset($cour->description)
                        <div class="card-body">
                            <p class="card-text">{{ $cour->description }}</p>
                        </div>
                    @endisset
                    <div class="card-footer text-muted">
                        <em>
                            <a href="{{ route('prof', $cour->prof->slug) }}" data-toggle="tooltip"
                               title="{{ __('Voir les cours de ') . $cour->prof->name }}">{{ $cour->prof->name }}</a>
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
                                        <a class="profs-manage"
                                           href="{{ route('cours.profs', $cour->id) }}"
                                           data-toggle="tooltip"
                                           title="@lang('Gérer les professeurs')">
                                            <i class="fa fa-folder-open"></i>
                                        </a>
                                    </span>
                                    <form action="{{ route('cours.destroy', $cour->id) }}" method="POST" class="hide">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @endadminOrOwner
                            </span>
                        </div>
                        <div class="star-rating" id="{{ $cour->id }}">
                            <span class="count-number">({{ $cour->users->count() }})</span>
                            <div id="{{ $cour->id . '.5' }}" data-toggle="tooltip" title="5" @if($cour->rate > 4) class="star-yellow" @endif>
                                <i class="fas fa-star"></i>
                            </div>
                            <div id="{{ $cour->id . '.4' }}" data-toggle="tooltip" title="4" @if($cour->rate > 3) class="star-yellow" @endif>
                                <i class="fas fa-star"></i>
                            </div>
                            <div id="{{ $cour->id . '.3' }}" data-toggle="tooltip" title="3" @if($cour->rate > 2) class="star-yellow" @endif>
                                <i class="fas fa-star"></i>
                            </div>
                            <div id="{{ $cour->id . '.2' }}" data-toggle="tooltip" title="2" @if($cour->rate > 1) class="star-yellow" @endif>
                                <i class="fas fa-star"></i>
                            </div>
                            <div id="{{ $cour->id . '.1' }}" data-toggle="tooltip" title="1" @if($cour->rate > 0) class="star-yellow" @endif>
                                <i class="fas fa-star"></i>
                            </div>

                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center">
            {{ $cours->links() }}
        </div>
    </main>
    @if($cours->count() == 0)
        <div class="alert alert-info" type="alert">
            Pas de cours
        </div>
    @endif
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
    <div class="modal fade" id="editProfs" tabindex="-1" role="dialog" aria-labelledby="profLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profLabel">@lang("Gestion du professeur pour le cours")</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="manageProfs" action="" method="POST">
                        <div class="form-group" id="listeProfs"></div>
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

            $('a.profs-manage').click((e) => {
                e.preventDefault()
                let that = $(e.currentTarget)
                that.tooltip('hide')
                that.children().removeClass('fa-folder-open').addClass('fa-cog fa-spin')
                e.preventDefault()
                $.get(that.attr('href'))
                    .done((data) => {
                        that.children().addClass('fa-folder-open').removeClass('fa-cog fa-spin')
                        $('#listeProfs').html(data)
                        $('#manageProfs').attr('action', that.attr('href'))
                        $('#editProfs').modal('show')
                    })
                    .fail(() => {
                        that.children().addClass('fa-folder-open').removeClass('fa-cog fa-spin')
                        swallAlertServer()
                    })
            })
            $('#manageProfs').submit((e) => {
                e.preventDefault()
                let that = $(e.currentTarget)
                $.ajax({
                    method: 'put',
                    url: that.attr('action'),
                    data: that.serialize()
                })
                    .done((data) => {
                        if(data === 'reload') {
                            location.reload();
                        } else {
                            $('#editProfs').modal('hide')
                        }
                    })
                    .fail(() => {
                        swallAlertServer()
                    })
            })

            let memoStars = []

            $('.star-rating div').click((e) => {
                @auth
                let element = $(e.currentTarget)
                let values = element.attr('id').split('.')
                element.addClass('fa-spin')
                $.ajax({
                    url: "{{ url('rating') }}" + '/' + values[0],
                    type: 'PUT',
                    data: {value: values[1]}
                })
                    .done((data) => {
                        if (data.status === 'ok') {
                            let cour = $('#' + data.id)
                            memoStars = []
                            cour.children('div')
                                .removeClass('star-yellow')
                                .each(function (index, element) {
                                    if (data.value > 4 - index) {
                                        $(element).addClass('star-yellow')
                                        memoStars.push(true)
                                    }
                                    memoStars.push(false)
                                })
                                .end()
                                .find('span.count-number')
                                .text('(' + data.count + ')')
                            if(data.rate) {
                                if(data.rate == values[1]) {
                                    title = '@lang("Vous avez déjà donné cette note !")'
                                } else {
                                    title = '@lang("Votre vote a été modifié !")'
                                }
                            } else {
                                title = '@lang("Merci pour votre vote !")'
                            }
                            swal.fire({
                                title: title,
                                icon: 'warning'
                            })
                        } else {
                            swal.fire({
                                title: '@lang('Vous ne pouvez pas voter pour vos photos !')',
                                icon: 'error'
                            })
                        }
                        element.removeClass('fa-spin')
                    })
                    .fail(() => {
                        swallAlertServer()
                        element.removeClass('fa-spin')
                    })
                @else
                swal.fire({
                    title: '@lang('Vous devez être connecté pour pouvoir voter !')',
                    icon: 'error'
                })
                @endauth
            })

            $('.star-rating').hover(
                (e) => {
                    memoStars = []
                    $(e.currentTarget).children('div')
                        .each((index, element) => {
                            memoStars.push($(element).hasClass('star-yellow'))
                        })
                        .removeClass('star-yellow')
                }, (e) => {
                    $.each(memoStars, (index, value) => {
                        if(value) {
                            $(e.currentTarget).children('div:eq(' + index + ')').addClass('star-yellow')
                        }
                    })
                })

        })
    </script>
@endsection
