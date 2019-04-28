<?php

namespace App\Http\Controllers;

use App\Client;
use App\Hotel;
use App\Reservation;
use App\ReservationStatus;
use App\Room;

class ReservationsController extends Controller
{
    /**
     * Reservations index view
     * includes relationships
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $resultsPerPage = 4;

        if (request()->wantsJson()) {
            $reservations = Reservation::with(['status', 'hotel'])
                                        ->withCount(['clients', 'rooms'])
                                        ->paginate($resultsPerPage);

            $data = $reservations->makeHidden([
                'reservation_status_id',
                'created_at',
                'updated_at',
                'hotel_id'
            ]);
            $reservations->data = $data;

            return response($reservations);
        }

        return view('reservations.index');
    }

    /**
     * Reservations show action
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show(Reservation $reservation)
    {
        $reservation = Reservation::with(['hotel', 'clients', 'rooms', 'status'])
                                    ->where('id', $reservation->id)
                                    ->get()
                                    ->first();

        if (request()->wantsJson()) {
            return response($reservation);
        }

        return view('reservations.form', compact('reservation'));
    }

    /**
     * Returns not synchronized to Google Calendar reservations
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function notSyncedReservations()
    {
        if (request()->wantsJson()) {
            $reservations = Reservation::with(['hotel', 'clients', 'rooms', 'status'])
                                        ->whereNull('google_event_id')->get();

            $payload = $this->prepareGoogleCalendarEventPayload($reservations);

            return response($payload);
        }
    }

    /**
     * Reservations create view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('reservations.form', ['reservation' => '[]']);
    }

    /**
     * Create a registration
     *
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function store()
    {
        return $this->save();
    }

    /**
     * Update a registration
     *
     * @param Reservation $reservation
     *
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function update(Reservation $reservation)
    {
        return $this->save($reservation);
    }

    /**
     * Save a reservation and attach clients and rooms
     *
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function save(Reservation $reservation = null)
    {
        $data = $this->validateRequestData();
        $response = [];

        if(empty($data['errors'])) {
            if($reservation) {
                $reservation->update($data['reservation']);
            } else {
                $reservation = Reservation::create($data['reservation']);
            }

            if($reservation) {
                $reservation->clients()->syncWithoutDetaching($data['clients']);
                $reservation->rooms()->syncWithoutDetaching($data['rooms']);
                $response = [
                    'message' => 'Reservation saved.'
                ];
            } else {
                $data['errors']['Error creating reservation.'];
            }
        }

        if(!empty($data['errors'])) {
            $response = response()->json($data, 400);
        }

        return $response;
    }

    public function destroy(Reservation $reservation)
    {
        $result = $reservation->delete();

        return response('', $result ? 200 : 404);
    }

    /**
     * Removes a client from the reservation
     *
     * @param Reservation $reservation
     * @param Client $client
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function deleteClient(Reservation $reservation, Client $client)
    {
        $result = $reservation->clients()->detach($client->id);

        return response('', $result ? 200 : 404);
    }

    /**
     * Validates reservation payload
     *
     * @return mixed
     */
    private function validateRequestData()
    {
        $result['errors'] = null;
        $data = request()->toArray();

        if(!Hotel::find($data['hotel']['id'] ?? 0)) {
            $result['errors']['hotel'] = ['Hotel not found.'];
        } else {
            $result['reservation']['hotel_id'] = $data['hotel']['id'] ?? 0;
        }

        if(!empty($data['status']['id']) && !ReservationStatus::find($data['status']['id'] ?? 0)) {
            $result['errors']['status'] = ['Status not found.'];
        } else {
            $result['reservation']['reservation_status_id'] = $data['status']['id'] ?? 0;
        }

        if(!empty($data['notes'])) {
            $result['reservation']['notes'] = $data['notes'];
        }

        $data['date_from'] = strtotime($data['date_from'] ?? '');
        if(!$data['date_from']) {
            $result['errors']['date_from'] = ['Date invalid.'];
        } else {
            $result['reservation']['date_from'] = date('Y-m-d', $data['date_from']);
        }

        $data['date_to'] = strtotime($data['date_to'] ?? '');
        if(!$data['date_to']) {
            $result['errors']['date_to'] = ['Date invalid.'];
        } else {
            $result['reservation']['date_to'] = date('Y-m-d', $data['date_to']);
        }

        $result['clients'] = [];
        foreach ($data['clients'] ?? [] as $client) {
            if(Client::find($client['id'])) {
                $result['clients'][] = $client['id'];
            } else {
                break;
            }
        }
        if(empty($result['clients']) || count($result['clients']) !== count($data['clients'] ?? [])) {
            unset($result['clients']);
            $result['errors']['clients'] = ['Invalid clients.'];
        }

        $rooms = array_merge($data['rooms'] ?? [], $data['newRooms'] ?? []);
        $result['rooms'] = [];
        foreach ($rooms as $room) {
            if(Room::find($room['id'])) {
                $result['rooms'][] = $room['id'];
            } else {
                break;
            }
        }
        if(empty($result['rooms']) || count($result['rooms']) !== count($rooms)) {
            unset($result['rooms']);
            $result['errors']['rooms'] = ['Invalid rooms.'];
        }

        return $result;
    }

    /**
     * Creates event payload for Google Calendar sync
     *
     * @param $reservations
     * @return array
     */
    private function prepareGoogleCalendarEventPayload($reservations)
    {
        $payload = [];

        foreach ($reservations as $reservation) {
            $payload[$reservation['id']]['summary'] = $this->prepareEventSummary($reservation);
            $payload[$reservation['id']]['start']['dateTime'] = $reservation['date_from'];
            $payload[$reservation['id']]['end']['dateTime'] = $reservation['date_to'];
            $payload[$reservation['id']]['description'] = $reservation['notes'];
            $payload[$reservation['id']]['attendees'] = $this->getEventAttendees($reservation['clients']->toArray());
        }

        return array_values($payload);
    }

    /**
     * Get Event summary including reservation data
     *
     * @param $reservation
     * @return array|string
     * @throws \Throwable
     */
    private function prepareEventSummary($reservation)
    {
        $data = [];

        $data['id'] = $reservation['id'];
        $data['hotel'] = $reservation['hotel']['name'];
        $data['clients'] = count($reservation['clients']);
        $data['rooms'] = count($reservation['rooms']);
        $data['status'] = $reservation['status']['type'];

        return view('reservations.google-event-summary', $data)->render();
    }

    /**
     * Prepare event attendee emails
     *
     * @param $clients
     * @return array
     */
    private function getEventAttendees($clients)
    {
        return array_map(function($client) {
            if(empty($client['email'])) {
                return;
            }
            return ['email' => $client['email']];
        }, $clients);
    }
}
