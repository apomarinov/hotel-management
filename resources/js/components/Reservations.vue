<script>
    import ReservationService from '../Services/ReservationService';
    import GoogleAPIService from '../Services/GoogleAPIService';

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
            prepareReservationSync() {
                if(this.googleEventPayload.length > 1) {
                    this.$dialog.confirm({
                        message: `Sync ${this.googleEventPayload.length} reservations?`,
                        onConfirm: this.syncReservations
                    });
                } else {
                    this.syncReservations();
                }
            },
            syncReservations() {
                let gButton = $(this.$refs['gButton']);
                gButton.addClass('is-loading');
                
                this.gapiService
                    .syncReservations(this.googleEventPayload)
                    .then(r => {
                        gButton.removeClass('is-loading');
                        this.$dialog.alert('Reservations Synced!')
                    })
                    .catch(r => gButton.removeClass('is-loading'));
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
            this.gapiService = new GoogleAPIService(this.$gapi);

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
