<template>
    <div>
        <div class="field is-horizontal">
            <div class="field-body">
                <b-field>
                    <b-input placeholder="Name..."
                             type="text"
                             min="5"
                             v-model="clientObj.name"
                             icon-pack="fas"
                             icon="user">
                    </b-input>
                </b-field>
                <b-field>
                    <b-input placeholder="Email"
                             type="email"
                             v-model="clientObj.email"
                             icon="email">
                    </b-input>
                </b-field>
            </div>
        </div>

        <div class="field is-horizontal">
            <div class="field-body">
                <div class="field is-expanded">
                    <div class="field has-addons">
                        <p class="control">
                            <a class="button is-static">
                                #
                            </a>
                        </p>
                        <p class="control is-expanded">
                            <input class="input" type="number" min="5" placeholder="Phone number" v-model="clientObj.phone">
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <p class="help is-danger" v-for="e in this.errors">
            {{ e[0] }}
        </p>
        <div class="columns" v-if="editMode">
            <div class="column"></div>
            <div class="column is-1">
                <a class="button is-link" @click="saveClient">Save</a>
            </div>
            <div class="column is-1" v-if="clientObj.id || inReservation">
                <a class="button is-danger" @click="deleteClient">Delete</a>
            </div>
            <div class="column"></div>
        </div>
        <div v-if="clientObj.reservations">
            <hr>
            <div class="column is-fullwidth has-text-centered"><strong class="is-size-3">Reservations</strong></div>
            <div class="columns is-marginless is-boxed is-fullwidth">
                <div class="column">
                    <div class="box" v-for="reservation in clientObj.reservations">
                        <div class="columns">
                            <div class="column"><i class="fas fa-h-square">&nbsp;</i><strong>{{ reservation.hotel.name }}</strong></div>
                            <div class="column"><strong>{{ reservation.date_from | moment('DD.MM.YYYY') }}</strong></div>
                            <div class="column is-1"><i class="fas fa-angle-right"></i></div>
                            <div class="column"><strong>{{ reservation.date_to | moment('DD.MM.YYYY') }}</strong></div>
                            <div class="column is-1">
                                <a class="level-item" @click="viewReservation(reservation.id)">
                                <span class="icon is-medium">
                                  <i class="fas fa-eye" aria-hidden="true"></i>
                                </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ClientService from "../Services/ClientService";
    import ReservationService from "../Services/ReservationService";

    export default {
        name: "ClientForm",
        props: [
            'data',
            'inReservation',
        ],
        data() {
            return {
                clientObj: {
                    id: 0,
                    name: '',
                    phone: '',
                    email: '',
                    reservations: []
                },
                errors: [],
                model: {}
            }
        },
        computed: {
            editMode() {
                return this.clientObj || !this.id;
            }
        },
        methods: {
            deleteClient() {
                // if form is used in reservation form
                // just emit to registration form
                if(!this.inReservation) {
                    this.$dialog.confirm({
                        message: 'Delete client?',
                        onConfirm: () => ClientService
                                            .delete(this.clientObj.id)
                                            .then(response => window.location.href = ClientService.apiUrl())
                    });
                } else {
                    this.$emit('delete');
                }
            },
            saveClient() {
                this.errors = [];

                ClientService.save(this.clientObj)
                    .then(data =>{
                        if(!this.inReservation) {
                            window.location.href = ClientService.apiUrl();
                        } else {
                            this.$emit('save', data);
                        }
                    })
                    .catch(response => {
                        if(response.errors) {
                            this.errors = response.errors;
                        }
                    });
            },
            viewReservation(id) {
                window.location.href = ReservationService.apiUrl() + '/' + id;
            }
        },
        created() {
            if(!this.inReservation) {
                this.clientObj = this.data;
            }
        }
    }
</script>
