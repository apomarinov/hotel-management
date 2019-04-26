<script>
    import ReservationService from '../Services/ReservationService';

    export default {
        name: "Reservations",
        data() {
            return {
                reservations: {}
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
                .then(data => this.reservations = data);
        }
    }
</script>
