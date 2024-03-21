<?php
namespace App\Repositories;

use PDO;
use App\Models\Appointment;

class BookingRepository extends Repository
{
    public function getAllTrainers()
    {
        $stmt = $this->db->prepare("SELECT TrainerId, FullName FROM TrainerDetails");
        $stmt->execute();

        $trainerData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $trainers = [];

        foreach ($trainerData as $data) {
            $trainers[] = [
                'trainerId' => $data['TrainerId'],
                'fullName' => $data['FullName']
            ];
        }

        return $trainers;

    }

    public function insert($booking)
    {
        $stmt = $this->db->prepare("INSERT INTO Appointments (ClientId, TrainerId, AppointmentDateTime, Duration, Status, Notes) VALUES (:client_id, :trainer_id, :date, :duration, :status, :notes)");

        $results = $stmt->execute([
            ':trainer_id' => $booking->getTrainerID(),
            ':client_id' => $booking->getClientID(),
            ':date' => $booking->getDate(),
            ':duration' => $booking->getDuration(),
            ':status' => $booking->getStatus(),
            ':notes' => $booking->getNotes()
        ]);

        return $results;
    }

    public function getBookingsByClient($client_id)
    {
        $stmt = $this->db->prepare("SELECT AppointmentID, ClientID, Appointments.TrainerID, TrainerDetails.FullName AS Trainer, AppointmentDateTime, Duration, Status
        FROM `Appointments` 
        JOIN TrainerDetails ON Appointments.TrainerID = TrainerDetails.TrainerID
        where ClientID = :clientId;");
        $stmt->execute([':clientId' => $client_id]);

        $bookingData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $bookings = [];

        foreach ($bookingData as $data) {
            $booking = new Appointment();
            $booking->setAppointmentID($data['AppointmentID']);
            $booking->setClientID($data['ClientID']);
            $booking->setTrainerID($data['TrainerID']);
            $booking->setTrainerName($data['Trainer']);
            $booking->setDate($data['AppointmentDateTime']);
            $booking->setDuration($data['Duration']);
            $booking->setStatus($data['Status']);

            $bookings[] = $booking;
        }

        return $bookings;
    }
}
