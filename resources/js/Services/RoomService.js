export default class RoomService {

    static roomsUrl() {
        return '/rooms';
    }

    static availableRoomsUrl() {
        return '/available-rooms';
    }

    static getAvailableRooms(data) {
        return this.list(this.availableRoomsUrl(), data);
    }

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
