<?php

namespace App\Http\Controllers;

use App\AmenityPackage;
use App\Client;
use App\Hotel;
use App\Reservation;
use App\ReservationStatus;
use App\Room;

class ReservationsController extends Controller
{
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

            return response($reservations, 201);
        }

        return view('reservations.index');
    }

    public function create()
    {
        return view('reservations.create');
    }

    public function store()
    {
        $data = $this->validateRequestData();
        $response = [];

        if(empty($data['errors'])) {
            $reservation = Reservation::create($data['reservation']);
            if($reservation) {
                $reservation->clients()->attach($data['clients']);
                $reservation->rooms()->attach($data['rooms']);
                $response = [
                    'message' => 'Reservation created.'
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

    public function deleteClient(Reservation $reservation, Client $client)
    {
        $result = $reservation->clients()->detach($client->id);

        return response('', $result ? 200 : 404);
    }

    private function validateRequestData()
    {
        $result['errors'] = null;
        $data = request()->toArray();

        if(!Hotel::find($data['hotel']['id'] ?? 0)) {
            $result['errors']['hotel'] = ['Hotel not found.'];
        } else {
            $result['reservation']['hotel_id'] = $data['hotel']['id'] ?? 0;
        }

        if(!empty($data['reservationStatus']['id']) && !ReservationStatus::find($data['reservationStatus']['id'] ?? 0)) {
            $result['errors']['reservationStatus'] = ['Status not found.'];
        } else {
            $result['reservation']['reservation_status_id'] = $data['reservationStatus']['id'] ?? 0;
        }

        if(!empty($data['notes'])) {
            $result['reservation']['notes'] = $data['notes'];
        }

        $data['dateFrom'] = strtotime($data['dateFrom'] ?? '');
        if(!$data['dateFrom']) {
            $result['errors']['dateFrom'] = ['Date invalid.'];
        } else {
            $result['reservation']['date_from'] = date('Y-m-d', $data['dateFrom']);
        }

        $data['dateTo'] = strtotime($data['dateTo'] ?? '');
        if(!$data['dateTo']) {
            $result['errors']['dateTo'] = ['Date invalid.'];
        } else {
            $result['reservation']['date_to'] = date('Y-m-d', $data['dateTo']);
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
}
