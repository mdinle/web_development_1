<?php
namespace App\Repositories;

use PDO;

class BookingRepository extends Repository
{
    public function getAllTrainers()
    {
        $stmt = $this->db->prepare("SELECT UserId, Username FROM Users WHERE UserType = 'trainer'");
        $stmt->execute();

        $trainerData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $trainers = [];

        foreach ($trainerData as $data) {
            $trainers[] = [
                'UserId' => $data['UserId'],
                'Username' => $data['Username']
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
}
