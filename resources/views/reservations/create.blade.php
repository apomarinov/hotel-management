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
                                                :min="new Date()"
                                                @change="reservation.dateFrom = $event">
                                            </date-picker>
                                        </div>
                                        <div class="field">
                                            <date-picker
                                                name="Date To"
                                                id="to"
                                                from-id="from"
                                                :min="new Date()"
                                                @change="reservation.dateTo = $event">
                                            </date-picker>
                                        </div>
                                    </div>
                                </div>
                                <p class="help is-danger" v-if="this.errors.dateFrom">
                                    @{{ this.errors.dateFrom[0] }}
                                </p>
                                <p class="help is-danger" v-if="this.errors.dateTo">
                                    @{{ this.errors.dateTo[0] }}
                                </p>
                                <textarea class="textarea" placeholder="Notes..." v-model="reservation.notes"></textarea>
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
                            <strong class="is-size-3">Rooms</strong>
                            <br>
                            <div class="columns is-mobile" v-if="!reservation.hotel.id">
                                <div class="column is-half is-offset-one-quarter has-text-centered notification is-warning is-large">Choose a hotel first</div>
                            </div>
                            <div v-if="reservation.hotel.id">
                                <div class="field is-horizontal" >
                                    <div class="field-body">
                                        <div class="field">
                                            <dropdown
                                                :value="amenityPackage"
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
                                    <div class="column is-3">
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
                                    <div class="column is-1"><strong>Room @{{ room.number }}</strong></div>
                                    <div class="column is-1"><strong>Floor: @{{ room.floor }}</strong></div>
                                    <div class="column is-2"><strong>Package: @{{ room.amenity_package.name }}</strong></div>
                                    <div class="column"></div>
                                </div>
                                <div class="columns" v-for="room in rooms">
                                    <div class="column"></div>
                                    <div class="column is-2">
                                        <div class="field">
                                            <b-checkbox type="is-info"
                                                        @input="toggleRoom(room, $event)">
                                                Add Room @{{ room.number }}
                                            </b-checkbox>
                                        </div>
                                    </div>
                                    <div class="column is-1"><strong>Floor: @{{ room.floor }}</strong></div>
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
                                <div class="column is-1">
                                    <button class="button is-success is-large" @click="submitReservation">Save</button>
                                </div>
                                <div class="column"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </reservation-form>
@endsection
