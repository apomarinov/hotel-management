@extends('layout.layout')

@section('content')
    <clients inline-template>
        <div>
            <div class="columns is-marginless" v-if="!showHelper">
                <div class="column field has-addons has-addons-centered">
                    <a class="button is-info is-inverted" href="/clients/create">
                        <span>Create Client</span>
                    </a>
                </div>
            </div>
            <div class="columns is-marginless is-boxed is-fullwidth">
                <div class="column"></div>
                <div class="column is-three-fifths">
                    <div class="box" v-for="client in clients.data">
                        <div class="columns">
                            <div class="column"><strong>@{{ client.name }}</strong></div>
                            <div class="column"><small>@{{ client.phone }}</small></div>
                            <div class="column"><small>@{{ client.email }}</small></div>
                            <div class="column is-1">
                                <a class="level-item" @click="viewClient(client.id)">
                                    <span class="icon is-medium">
                                      <i class="fas fa-marker" aria-hidden="true"></i>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="has-text-centered" v-if="showHelper" style="font-size: 1.4rem;">
                        There are no clients.
                        <a class="button is-info is-inverted" href="/clients/create">
                            <span>Create</span>
                        </a>
                        a new one.
                    </div>
                </div>
                <div class="column"></div>
            </div>
            <div class="columns is-marginless">
                <div class="column"></div>
                <div class="column is-three-fifths">
                    <pagination :data="clients" :limit="2" @pagination-change-page="getResults">
                        <span slot="prev-nav">&lt; Previous</span>
                        <span slot="next-nav">Next &gt;</span>
                    </pagination>
                </div>
                <div class="column"></div>
            </div>
        </div>
    </clients>
@endsection
