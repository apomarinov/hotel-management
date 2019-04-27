export default class RoomService {

    /**
     * RoomsUrl resrouce url
     *
     * @returns {string}
     */
    static roomsUrl() {
        return '/rooms';
    }

    /**
     * AvailableRoomsUrl resrouce url
     *
     * @returns {string}
     */
    static availableRoomsUrl() {
        return '/available-rooms';
    }

    /**
     * Get available rooms
     *
     * @param data
     */
    static getAvailableRooms(data) {
        return this.list(this.availableRoomsUrl(), data);
    }

    /**
     * Get room listing
     *
     * @param url
     * @param data
     * @returns {Promise<any>}
     */
    static list(url, data) {
        return new Promise((resolve, reject) => {
            axios.get(url, {params: data})
                .then(response => {
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error.response.data);
                });
        });
    }
}
