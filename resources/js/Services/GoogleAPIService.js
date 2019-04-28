export default class GoogleAPIService {

    /**
     * Creates a GoogleAPIService instance
     *
     * @param gapi
     */
    constructor(gapi) {
        this.gapi = gapi;
    }

    /**
     * Sync reservations to Google Calendar
     *
     * @param reservations
     * @returns {Promise<any>}
     */
    syncReservations(reservations)
    {
        return new Promise((resolve, reject) => {
            this.gapi.signIn()
                .then(user => {
                    this.gapi._libraryLoad('client')
                        .then(client => {
                            let batch = client.newBatch();

                            for (var i = 0; i < reservations.length; i++) {
                                batch.add(client.request({
                                    path: 'https://content.googleapis.com/calendar/v3/calendars/primary/events',
                                    method: 'POST',
                                    body: reservations[i]
                                }));
                            }

                            batch.execute(response => {
                                resolve(response);
                            });
                        })
                        .catch(err => {
                            reject(err);
                        });
                })
                .catch(err => {
                    reject(err);
                });
        });
    }
}
