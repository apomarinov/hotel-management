<script>
    import ReservationService from '../Services/ReservationService';
    import ClientService from "../Services/ClientService";

    export default {
        name: "ReservationForm",
        data() {
            return {
                reservation: {
                    hotel: {},
                    dateFrom: {},
                    dateTo: {},
                    clients: [
                        {
                            name: "Apostol Marinov",
                            phone: "0889601333",
                            email: "apomarinov@gmail.com",
                            updated_at: "2019-04-26 15:35:30",
                            created_at: "2019-04-26 15:35:30",
                            id: 55
                        }
                    ],
                    rooms: [
                        {
                            "id": 2,
                            "hotel_id": 1,
                            "floor": 1,
                            "number": 112,
                            "amenity_package": {
                                "id": 1,
                                "name": "Standard"
                            }
                        },
                        {
                            "id": 6,
                            "hotel_id": 1,
                            "floor": 4,
                            "number": 411,
                            "amenity_package": {
                                "id": 4,
                                "name": "Suite"
                            }
                        },
                        {
                            "id": 7,
                            "hotel_id": 2,
                            "floor": 1,
                            "number": 111,
                            "amenity_package": {
                                "id": 1,
                                "name": "Standard"
                            }
                        }
                    ]
                },
                newClient: null,
                amenityPackage: [
                    {
                        "id": 1,
                        "name": "Standard"
                    }
                ],
                roomFilters: [
                    {
                        "id": 4,
                        "type": "misc",
                        "value": "Pet Friendly"
                    },
                    {
                        "id": 1,
                        "type": "view",
                        "value": "Pool Side"
                    }
                ]
            }
        },
        computed: {
            clientButtonClasses() {
                let classes = ['button'];

                if(this.newClient) {
                    classes.push('is-link');
                } else {
                    classes.push('is-success');
                }

                return classes;
            },
            clientButtonName() {
                let name = 'New';

                if(this.newClient) {
                    name = 'Save';
                }

                return name;
            }
        },
        methods: {
            clientSaved(newClient) {
                this.reservation.clients.push(newClient);
                this.newClient = null;
            },
            removeClientFromReservation(clientId) {
                let promise;

                if(this.reservation.id) {
                    promise = ReservationService.removeClient(this.reservation.id, clientId);
                } else {
                    promise = ClientService.delete(clientId);
                }

                promise.then(response => {
                    this.reservation.clients = this.reservation.clients.filter(function( obj ) {
                        return obj.id != clientId;
                    });
                });
            }
        },
        created() {
            console.log(1);
        }
    }
</script>
