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

            if ($data && isset($data['clientId'], $data['trainerId'], $data['date'], $data['duration'])) {
                $clientId = filter_var($data['clientId'], FILTER_SANITIZE_NUMBER_INT);
                $trainerId = filter_var($data['trainerId'], FILTER_SANITIZE_NUMBER_INT);
                $date = htmlspecialchars($data['date']);
                $duration = filter_var($data['duration'], FILTER_SANITIZE_NUMBER_INT);
                $notes = isset($data['notes']) ? htmlspecialchars($data['notes']) : null;

                $appointment = new Appointment();
                $appointment->setClientID($clientId);
                $appointment->setTrainerID($trainerId);
                $appointment->setDate($date);
                $appointment->setDuration($duration);
                $appointment->setStatus('pending');
                $appointment->setNotes($notes);

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
            }else{
                http_response_code(400);
                echo json_encode(['message' => 'Missing required fields']);
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

            if(isset($data['appointmentId'])){
                $booking_id = filter_var($data['appointmentId'], FILTER_SANITIZE_NUMBER_INT);
            }else {
                http_response_code(400);
                echo json_encode(['message' => 'Missing appointmentId']);
                return;
            }

            try {
                if($this->bookingService->deleteBooking($booking_id)) {
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
