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

            $result = $this->bookingService->createBooking($appointment);
            if ($result) {
                echo json_encode(['message' => 'Booking was made succesfully']);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Failed to make booking']);
            }
        }
        
    }
}
