export default class ReservationService {

    static apiUrl() {
        return '/reservations';
    }

    static clientsUrl() {
        return 'clients';
    }

    static list(page) {
        return new Promise((resolve, reject) => {
            axios.get(this.apiUrl(), {params: {page: page}})
                .then(response => {

                    resolve(response.data);
                })
                .catch(error => {
                    reject(error.response.data);
                });
        });
    }

    static removeClient(reservationId, clientId) {
        return new Promise((resolve, reject) => {
            let url = this.apiUrl()+`/${reservationId}/`+this.clientsUrl()+`/${clientId}`;
            axios.delete(url)
                .then(response => {
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error.response.data);
                });
        });
    }
}
