export default class ReservationService {

    /**
     * Resource url
     *
     * @returns {string}
     */
    static apiUrl() {
        return '/reservations';
    }

    /**
     * Resource edit url
     *
     * @returns {string}
     */
    static editUrl() {
        return this.apiUrl()+'/edit';
    }

    /**
     * Google Events Resource url
     *
     * @returns {string}
     */
    static googleEventUrl() {
        return '/google-events';
    }

    /**
     * Clients Resource url
     *
     * @returns {string}
     */
    static clientsUrl() {
        return 'clients';
    }

    /**
     * Get reservation listing
     *
     * @param page
     * @returns {Promise<any>}
     */
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

    /**
     * Get Google Event payload for synchronization
     * TODO: move to GoogleAPI service...
     *
     * @param page
     * @returns {Promise<any>}
     */
    static getGoogleEventPayload() {
        return new Promise((resolve, reject) => {
            axios.get(this.googleEventUrl())
                .then(response => {
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error.response.data);
                });
        });
    }

    /**
     * Remove client from reservation
     *
     * @param reservationId
     * @param clientId
     * @returns {Promise<any>}
     */
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

    /**
     * Save reservation
     *
     * @param data
     * @returns {Promise<any>}
     */
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
