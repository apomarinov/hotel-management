export default class ResourceService {

    static apiUrl() {
        return '/';
    }

    /**
     * Get listing
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
     * Save resource
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


    /**
     * Delete reservation
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
