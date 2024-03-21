<?php
namespace App\Repositories;

use PDO;
use App\Models\Appointment;
use Exception;

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

        if (!$results) {
            throw new Exception("Failed to insert booking into database.");
        }
    
        return $results;
    }

    public function delete($appointmentID)
    {
        $stmt = $this->db->prepare("DELETE FROM Appointments WHERE AppointmentID = :appointmentID");
        $results = $stmt->execute([':appointmentID' => $appointmentID]);

        if (!$results) {
            throw new Exception("Failed to delete booking.");
        } else {
            return $results;
        }
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

    public function checkAvailibilty($booking)
    {
        $start_time = $booking->getDate();
        $duration_minutes = $booking->getDuration();
        $end_time = date('Y-m-d H:i:s', strtotime("$start_time + $duration_minutes minutes"));
        ;

        $stmt = $this->db->prepare("SELECT *
        FROM Appointments
        WHERE
            TrainerID = 1
            AND (
                AppointmentDateTime < :end_time
                AND DATE_ADD(AppointmentDateTime, INTERVAL Duration HOUR_MINUTE) > :start_time
            );");

        $stmt->execute([
            ':start_time' => $start_time,
            ':end_time' => $end_time]);

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        
        if ($results) {
            throw new Exception("Trainer is not available at this time.");
        } else {
            return $this->insert($booking);
        }
             
    }

    public function canCancelAppointment($appointmentID)
    {
        $stmt = $this->db->prepare("SELECT Status FROM Appointments WHERE AppointmentID = :appointmentID");
        $stmt->execute([':appointmentID' => $appointmentID]);

        $status = $stmt->fetch(PDO::FETCH_ASSOC);

        if($status['Status'] === 'pending') {
            return $this->delete($appointmentID);
        } else {
            throw new Exception("Cannot cancel appointment. Trainer has already accepted session.");
        }
    }
}
