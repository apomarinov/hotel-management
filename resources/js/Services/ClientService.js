export default class ReservationService {

    /**
     * Resource url
     *
     * @returns {string}
     */
    static apiUrl() {
        return '/clients';
    }

    /**
     * Get client listing
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
     * Save client
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
                    console.log(response);
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error.response.data);
                });
        });
    }

    /**
     * Delete client
     *
     * @param id
     * @returns {Promise<any>}
     */
    static delete(id) {
        return new Promise((resolve, reject) => {
            let url = this.apiUrl()+`/${id}`;
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
