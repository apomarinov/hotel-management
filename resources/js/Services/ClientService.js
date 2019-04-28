import ResourceService from './ResourceService';

export default class ClientService extends ResourceService {

    /**
     * Resource url
     *
     * @returns {string}
     */
    static apiUrl() {
        return '/clients';
    }
}
