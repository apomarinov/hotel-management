export default class ReservationService {

    static apiUrl() {
        return 'reservations';
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
}
