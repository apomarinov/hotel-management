@extends('layout.layout')

@section('content')
    <reservations inline-template>
        <div>
            <div class="columns is-marginless is-boxed is-fullwidth">
                <div class="column"></div>
                <div class="column is-three-fifths">
                    <pagination :data="reservations" :limit="2" @pagination-change-page="getResults">
                        <span slot="prev-nav">&lt; Previous</span>
                        <span slot="next-nav">Next &gt;</span>
                    </pagination>
                </div>
                <div class="column"></div>
            </div>
            <div class="columns is-marginless is-boxed is-fullwidth">
                <div class="column"></div>
                <div class="column is-three-fifths">

                    <div class="box" v-for="r in reservations.data">
                        <article class="media">
                            <div class="media-content">
                                <div class="content">
                                    <p>
                                        <strong><i class="fas fa-h-square"></i> @{{ r.hotel.name }}</strong>
                                        <small>@{{ r.date_from | moment('DD.MM.YYYY') }}</small> to <small>@{{ r.date_to | moment('DD.MM.YYYY')}}</small>
                                        <br>
                                        @{{ r.notes | truncate(200) }}
                                    </p>
                                </div>
                                <nav class="level is-mobile">
                                    <div class="level-left">
                                        <div class="level-item">
                                        <span class="icon is-medium">
                                          <i class="fas fa-users"></i>
                                        </span>
                                            @{{ r.clients_count }}
                                        </div>
                                        <div class="level-item">
                                        <span class="icon is-medium">
                                          <i class="fas fa-door-closed"></i>
                                        </span>
                                            @{{ r.rooms_count }}
                                        </div>
                                    </div>
                                    <div class="level-right">
                                        <a class="level-item" @click="editReservation(r.id)">
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
            <div class="columns is-marginless is-boxed is-fullwidth">
                <div class="column"></div>
                <div class="column is-three-fifths">
                    <pagination :data="reservations" :limit="2" @pagination-change-page="getResults">
                        <span slot="prev-nav">&lt; Previous</span>
                        <span slot="next-nav">Next &gt;</span>
                    </pagination>
                </div>
                <div class="column"></div>
            </div>
        </div>
    </reservations>
@endsection
