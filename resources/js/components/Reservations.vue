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
            editReservation(id) {
                console.log(id);
            },
            syncReservationsToGoogle() {
                let gButton = $(this.$refs['gButton']);

                this.$gapi.signIn()
                    .then(user => {
                        gButton.addClass('is-loading');

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
                                    console.log(response)
                                });
                            })
                            .catch(err => {
                                gButton.removeClass('is-loading');
                            });
                    })
                    .catch(err => {
                        gButton.removeClass('is-loading');
                    });
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
