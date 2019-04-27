<script>
    import ReservationService from '../Services/ReservationService';

    export default {
        name: "Reservations",
        data() {
            return {
                reservations: {},
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
        }
    }
</script>
