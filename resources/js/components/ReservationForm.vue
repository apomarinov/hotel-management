<script>
    import ReservationService from '../Services/ReservationService';
    import ClientService from "../Services/ClientService";
    import RoomService from "../Services/RoomService";

    export default {
        name: "ReservationForm",
        props: [
          'data'
        ],
        data() {
            return {
                reservation: {
                    hotel: {},
                    status: {},
                    date_from: '',
                    date_to: '',
                    notes: '',
                    clients: [],
                    newRooms: [],
                    rooms: []
                },
                newClient: null,
                noRoomsFound: false,
                amenityPackage: [],
                rooms: [],
                roomFilters: [],
                errors: []
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
            },
            statusDropdownResource() {
                let resource = '/reservation-status';

                if(!this.reservation.id) {
                    resource += '?on_create';
                }

                return resource;
            }
        },
        created() {
            if(this.data.id) {
                this.reservation = this.data;
                this.reservation.newRooms = [];
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
            },
            addFilter(f) {
                if(this.roomFilters.indexOf(f) < 0) {
                    this.roomFilters.push(f);
                }
                this.getRooms();
            },
            removeFilter(f) {
                this.roomFilters = this.roomFilters.filter(function( obj ) {
                    return obj.id != f.id;
                });
                this.getRooms();
            },
            changeAmenityPackage(p) {
                this.amenityPackage = p;
                this.getRooms();
            },
            getRooms() {
                this.noRoomsFound = false;
                let roomFilters = {
                    attributes: this.roomFilters.map(f => f.id),
                    hotel_id: this.reservation.hotel.id || 0,
                    package_id: this.amenityPackage.id || 0
                };
                RoomService
                    .getAvailableRooms(roomFilters)
                    .then(response => {
                        this.rooms = response;
                        this.noRoomsFound = this.rooms.length == 0;
                    });
            },
            toggleRoom(room, state) {
                if(state) {
                    if(this.reservation.newRooms.indexOf(room) < 0) {
                        this.reservation.newRooms.push(room);
                    }
                } else {
                    this.reservation.newRooms = this.reservation.newRooms.filter(function( obj ) {
                        return obj.id != room.id;
                    });
                }
            },
            submitReservation() {
                let canSubmit = true;
                canSubmit = canSubmit && this.reservation.hotel.id;
                canSubmit = canSubmit && this.reservation.date_from;
                canSubmit = canSubmit && this.reservation.date_to;
                canSubmit = canSubmit && this.reservation.status.id;
                canSubmit = canSubmit && this.reservation.clients.length;
                canSubmit = canSubmit && (this.reservation.newRooms && this.reservation.newRooms.length || this.reservation.rooms.length);

                if(canSubmit) {
                    ReservationService.save(this.reservation)
                        .then(data => {
                            window.location.href = ReservationService.apiUrl();
                        })
                        .catch(response => {
                            this.errors = response.errors || [];
                        });
                }
            },
            deleteReservation() {
                this.$dialog.confirm({
                    message: 'Delete reservation?',
                    onConfirm: () => ReservationService
                        .delete(this.reservation.id)
                        .then(response => window.location.href = ReservationService.apiUrl())
                });
            }
        }
    }
</script>
