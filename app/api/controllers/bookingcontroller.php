<?php
use App\Services\BookingService;
use App\Models\Appointment;

class BookingController
{
    private $bookingService;

    public function __construct()
    {
        $this->bookingService = new BookingService();
    }

    public function create()
    {
        if (!isset($_SESSION['user'])) {
            http_response_code(401);
            echo json_encode(['message' => 'Unauthorized']);
            return;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);

            $appointment = new Appointment();
            $appointment->setClientID($data['clientId']);
            $appointment->setTrainerID($data['trainerId']);
            $appointment->setDate($data['date']);
            $appointment->setDuration($data['duration']);
            $appointment->setStatus('pending');
            $appointment->setNotes($data['notes']);

            try {
                if($this->bookingService->checkAvailibilty($appointment)) {
                    http_response_code(200);
                    echo json_encode(['message' => 'Booking created']);
                }
            } catch(Exception $e) {
                http_response_code(500);
                echo json_encode(['message' => $e->getMessage()]);
                return;
            }
            
        }
    }

    public function delete()
    {
        if (!isset($_SESSION['user'])) {
            http_response_code(401);
            echo json_encode(['message' => 'Unauthorized']);
            return;
        }

        if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);

            if(!isset($data)) {
                http_response_code(400);
                echo json_encode(['message' => 'Missing appointmentId']);
                return;
            }

            try {
                if($this->bookingService->deleteBooking($data)) {
                    http_response_code(200);
                    echo json_encode(['message' => 'Booking deleted']);
                }
            } catch(Exception $e) {
                http_response_code(500);
                echo json_encode(['message' => $e->getMessage()]);
                return;
            }
        }
    }
}
