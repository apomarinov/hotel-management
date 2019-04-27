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

    static save(data) {
        let url = this.apiUrl();
        let method = 'post';
        if(data.id) {
            url = `${url}/${data.id}`;
            method = 'patch';
        }
        return new Promise((resolve, reject) => {
            axios[method](url, data)
                .then(response => {
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error.response.data);
                });
        });
    }
}
