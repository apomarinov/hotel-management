@extends('layout.layout')

@section('content')
    @foreach($reservations as $r)
        <div class="columns" >
            <div class="column"></div>
            <div class="column is-three-fifths">
                <div class="box">
                    <article class="media">
                        <div class="media-content">
                            <div class="content">
                                <p>
                                    <strong><i class="fas fa-h-square"></i> {{$r->hotel->name}}</strong> <small>{{ $r->date_from->format($datesFormat) }}</small> to <small>{{ $r->date_to->format($datesFormat) }}</small>
                                    <br>
                                    {{ Str::limit($r->notes, $limit = $notesLimit, $end = '...') }}
                                </p>
                            </div>
                            <nav class="level is-mobile">
                                <div class="level-left">
                                    <div class="level-item">
                                        <span class="icon is-medium">
                                          <i class="fas fa-users"></i>
                                        </span>
                                        {{ $r->clients_count }}
                                    </div>
                                    <div class="level-item">
                                        <span class="icon is-medium">
                                          <i class="fas fa-door-closed"></i>
                                        </span>
                                        {{ $r->rooms_count }}
                                    </div>
                                </div>
                                <div class="level-right">
                                    <a class="level-item" href="/reservations/{{ $r->id }}/edit">
                                        <span class="icon is-medium">
                                          <i class="fas fa-marker" aria-hidden="true"></i>
                                        </span>
                                    </a>
                                </div>
                            </nav>
                        </div>
                    </article>
                </div>
            </div>
            <div class="column"></div>
        </div>
    @endforeach
@endsection

@section('footer')
    {{ $reservations->render() }}
@endsection
