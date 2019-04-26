@extends('layout.layout')

@section('content')
    <reservation-form inline-template>
        <div>
            <div class="box">
                <div class="media">
                    <div class="media-content">
                        <div class="content">
                            <p>
                                <strong class="is-size-3">Reservation</strong>
                                <br>
                                <div class="field is-horizontal">
                                    <div class="field-body">
                                        <div class="field">
                                            <dropdown
                                                :value="reservation.hotel"
                                                color="is-info"
                                                name="Choose Hotel"
                                                icon="fas f-h-square"
                                                resource="/hotels"
                                                value-name="id"
                                                option-name="name"
                                                @change="reservation.hotel = $event">
                                            </dropdown>
                                        </div>
                                    </div>
                                </div>
                                <div class="field is-horizontal">
                                    <div class="field-body">
                                        <div class="field">
                                            <date-picker
                                                name="Date From"
                                                id="from"
                                                to-id="to"
                                                @change="reservation.dateFrom = $event">
                                            </date-picker>
                                        </div>
                                        <div class="field">
                                            <date-picker
                                                name="Date To"
                                                id="to"
                                                from-id="from"
                                                @change="reservation.dateTo = $event">
                                            </date-picker>
                                        </div>
                                    </div>
                                </div>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="media">
                    <div class="media-content">
                        <div class="content">
                            <p>
                                <strong class="is-size-3">Clients</strong>
                                <br>
                                <div class="box" v-for="client in reservation.clients">
                                    <div class="columns">
                                        <div class="column"><strong>@{{ client.name }}</strong></div>
                                        <div class="column"><small>@{{ client.phone }}</small></div>
                                        <div class="column"><small>@{{ client.email }}</small></div>
                                        <div class="column is-1"><a class="button is-danger" @click="removeClientFromReservation(client.id)"><i class="fas fa-times"></i></a></div>
                                    </div>
                                </div>
                                <client-form v-if="newClient" @save="clientSaved($event)" @delete="newClient = null"></client-form>
                                <div class="columns" v-if="!newClient">
                                    <div class="column is-one-fifth">
                                        <a class="button is-success" @click="newClient = {}">New</a>
                                    </div>
                                    <div class="column"></div>
                                    <div class="column"></div>
                                </div>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="media">
                    <div class="media-content">
                        <div class="content">
                            <p>
                                <strong class="is-size-3">Rooms</strong>
                                <br>
                                <div class="field is-horizontal">
                                    <div class="field-body">
                                        <div class="field">
                                            <dropdown
                                                :value="reservation.rooms"
                                                name="Choose Hotel"
                                                icon="fas f-h-square"
                                                resource="/hotels"
                                                value-name="id"
                                                option-name="name"
                                                @change="reservation.hotel = $event">
                                            </dropdown>
                                        </div>
                                    </div>
                                </div>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </reservation-form>
@endsection
