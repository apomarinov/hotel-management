import ResourceService from './ResourceService';

export default class RoomService extends ResourceService {

    /**
     * RoomsUrl url
     *
     * @returns {string}
     */
    static apiUrl() {
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
}
