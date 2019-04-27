<script>
    import ReservationService from '../Services/ReservationService';

    export default {
        name: "Reservations",
        data() {
            return {
                reservations: {},
                googleEventPayload: {},
                showHelper: false
            }
        },
        methods: {
            getResults(page) {
                ReservationService
                    .list(page)
                    .then(data => this.reservations = data);
            },
            viewReservation(id) {
                window.location.href = ReservationService.apiUrl() + '/' + id;
            },
            syncReservationsToGoogle() {
                let gButton = $(this.$refs['gButton']);

                // TODO: move to GoogleAPI service...
                gButton.addClass('is-loading');
                this.$gapi.signIn()
                    .then(user => {
                        this.$gapi._libraryLoad('client')
                            .then(client => {
                                let batch = client.newBatch();

                                for (var i = 0; i < this.googleEventPayload.length; i++) {
                                    batch.add(client.request({
                                        path: 'https://content.googleapis.com/calendar/v3/calendars/primary/events',
                                        method: 'POST',
                                        body: this.googleEventPayload[i]
                                    }));
                                }

                                batch.execute(response => {
                                    gButton.removeClass('is-loading');
                                    this.$dialog.alert('Reservations Synced!')
                                });
                            })
                            .catch(err => {
                                gButton.removeClass('is-loading');
                            });
                    })
                    .catch(err => {
                        gButton.removeClass('is-loading');
                    });
            },
            reservationSyncFail() {
                this.$dialog.alert({
                    title: 'Error',
                    message: 'Reservation Sync Failed.',
                    type: 'is-danger',
                    hasIcon: true,
                    icon: 'times-circle',
                    iconPack: 'fa'
                })
            }
        },
        created() {
            ReservationService
                .list(1)
                .then(data => {
                    this.reservations = data;

                    if(!this.reservations.data || !this.reservations.data.length) {
                        this.showHelper = true;
                    }
                });
            ReservationService
                .getGoogleEventPayload()
                .then(data => {
                    this.googleEventPayload = data;
                });
        }
    }
</script>
