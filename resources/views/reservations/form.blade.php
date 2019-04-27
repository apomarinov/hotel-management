@extends('layout.layout')

@section('content')
    <reservation-form :data="{{ $reservation }}" inline-template>
        <div class="columns is-centered">
            <div class="column is-7">
                <div class="box">
                    <div class="media">
                        <div class="media-content">
                            <div class="content">
                                <p>
                                <div class="column is-fullwidth has-text-centered"><strong class="is-size-3">Reservation</strong></div>
                                <div class="columns">
                                    <div class="column"></div>
                                    <div class="column is-one-fifth field has-addons has-addons-centered">
                                        <dropdown
                                            :model="reservation.hotel"
                                            color="is-info"
                                            :no-default="true"
                                            name="Choose Hotel"
                                            icon="fas f-h-square"
                                            resource="/hotels"
                                            value-name="id"
                                            option-name="name"
                                            @change="reservation.hotel = $event">
                                        </dropdown>
                                    </div>
                                    <div class="column"></div>
                                </div>
                                <div class="field is-horizontal">
                                    <div class="field-body">
                                        <div class="field">
                                            <date-picker
                                                :model="reservation.date_from"
                                                name="Date From"
                                                id="from"
                                                to-id="to"
                                                :min="new Date()"
                                                @change="reservation.date_from = $event">
                                            </date-picker>
                                        </div>
                                        <div class="field">
                                            <date-picker
                                                :model="reservation.date_to"
                                                name="Date To"
                                                id="to"
                                                from-id="from"
                                                :min="new Date()"
                                                @change="reservation.date_to = $event">
                                            </date-picker>
                                        </div>
                                    </div>
                                </div>
                                <p class="help is-danger" v-if="this.errors.date_from">
                                    @{{ this.errors.date_from[0] }}
                                </p>
                                <p class="help is-danger" v-if="this.errors.date_to">
                                    @{{ this.errors.date_to[0] }}
                                </p>
                                <b-field>
                                    <b-input v-model="reservation.notes"
                                             :has-counter="true"
                                             type="textarea"
                                             maxlength="1000"
                                             placeholder="Notes">
                                    </b-input>
                                </b-field>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-content">
                            <div class="content">
                                <p>
                                <div class="column is-fullwidth has-text-centered"><strong class="is-size-3">Clients</strong></div>
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
                                    <div class="column"></div>
                                    <div class="column is-one-fifth field has-addons has-addons-centered">
                                        <a class="button is-success" @click="newClient = {}">New</a>
                                    </div>
                                    <div class="column"></div>
                                </div>
                                <p class="help is-danger" v-if="this.errors.clients">
                                    @{{ this.errors.clients[0] }}
                                </p>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-content">
                            <div class="content">
                                <div class="column is-fullwidth has-text-centered"><strong class="is-size-3">Rooms</strong></div>
                                <br>
                                <div class="columns is-mobile" v-if="!reservation.hotel.id">
                                    <div class="column is-half is-offset-one-quarter has-text-centered notification is-warning is-large">Choose a hotel first</div>
                                </div>
                                <div v-if="reservation.hotel.id">
                                    <div class="field is-horizontal" >
                                        <div class="field-body">
                                            <div class="field">
                                                <dropdown
                                                    :model="amenityPackage"
                                                    color="is-info"
                                                    name="Choose Amenity Package"
                                                    resource="/amenity-packages"
                                                    value-name="id"
                                                    option-name="name"
                                                    @change="changeAmenityPackage($event)">
                                                </dropdown>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="columns" v-if="!amenityPackage.id">
                                        <div class="column is-5">
                                            <div class="field">
                                                <autocomplete
                                                    placeholder="Search Room Attributes"
                                                    resource="/attributes"
                                                    search-path="value"
                                                    @change="addFilter($event)">
                                                </autocomplete>
                                            </div>
                                        </div>
                                        <div class="column">
                                            <b-field grouped group-multiline>
                                                <div class="control" v-for="filter in roomFilters">
                                                    <b-tag @close="removeFilter(filter)" :id="filter.id" type="is-link" size="is-medium" attached closable>@{{ filter.value }}</b-tag>
                                                </div>
                                            </b-field>
                                        </div>
                                    </div>
                                    <div class="columns is-mobile" v-if="noRoomsFound">
                                        <div class="column is-half is-offset-one-quarter has-text-centered notification is-large">No rooms</div>
                                    </div>
                                    <div class="columns" v-for="room in reservation.rooms">
                                        <div class="column"></div>
                                        <div class="column is-2"><strong>Room @{{ room.number }}</strong></div>
                                        <div class="column is-2"><strong>Floor: @{{ room.floor }}</strong></div>
                                        <div class="column"></div>
                                    </div>
                                    <div class="columns" v-for="room in rooms">
                                        <div class="column"></div>
                                        <div class="column is-3">
                                            <div class="field">
                                                <b-checkbox type="is-info"
                                                            @input="toggleRoom(room, $event)">
                                                    Add Room @{{ room.number }}
                                                </b-checkbox>
                                            </div>
                                        </div>
                                        <div class="column is-2"><strong>Floor: @{{ room.floor }}</strong></div>
                                        <div class="column"></div>
                                    </div>
                                </div>
                                <p></p>
                                <p class="help is-danger" v-if="this.errors.rooms">
                                    @{{ this.errors.rooms[0] }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-content">
                            <div class="content">
                                <div class="columns">
                                    <div class="column"></div>
                                    <div class="column is-1 field has-addons has-addons-centered">
                                        <dropdown
                                            :model="reservation.status"
                                            :no-default="true"
                                            color="is-info"
                                            name="Choose Status"
                                            :resource="statusDropdownResource"
                                            option-name="type"
                                            @change="reservation.status = $event">
                                        </dropdown>
                                    </div>
                                    <div class="column"></div>
                                </div>
                                <div class="columns" v-if="reservation.status.id">
                                    <div class="column"></div>
                                    <div class="column is-1  field has-addons has-addons-centered">
                                        <button class="button is-success is-large" @click="submitReservation">Save</button>
                                    </div>
                                    <div class="column"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </reservation-form>
@endsection
