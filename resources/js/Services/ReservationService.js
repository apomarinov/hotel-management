import ResourceService from './ResourceService';

export default class ReservationService extends ResourceService {

    /**
     * Resource url
     *
     * @returns {string}
     */
    static apiUrl() {
        return '/reservations';
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
     * Get Google Event payload for synchronization
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
}
