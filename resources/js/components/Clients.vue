<script>
    import ClientService from '../Services/ClientService';

    export default {
        name: "Clients",
        data() {
            return {
                clients: {},
                showHelper: false
            }
        },
        methods: {
            getResults(page) {
                ClientService
                    .list(page)
                    .then(data => this.clients = data);
            },
            viewClient(id) {
                window.location.href = ClientService.apiUrl() + '/' + id;
            }
        },
        created() {
            ClientService
                .list(1)
                .then(data => {
                    this.clients = data;

                    if(!this.clients.data || !this.clients.data.length) {
                        this.showHelper = true;
                    }
                });
        }
    }
</script>
