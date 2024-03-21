<?php
namespace App\Models;

use DateTime;

class Appointment
{
    private $appointmentID;
    private $clientID;
    private $trainerID;
    private $date;
    private $duration;
    private $status;
    private $notes;

    public function getAppointmentID()
    {
        return $this->appointmentID;
    }

    public function setAppointmentID($appointmentID)
    {
        $this->appointmentID = $appointmentID;
    }

    public function getTrainerID()
    {
        return $this->trainerID;
    }

    public function setTrainerID($trainerID)
    {
        $this->trainerID = $trainerID;
    }

    public function getClientID()
    {
        return $this->clientID;
    }

    public function setClientID($clientID)
    {
        $this->clientID = $clientID;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $dateTime = new DateTime($date);

        $formattedDate = $dateTime->format('Y-m-d H:i:s');

        $this->date = $formattedDate;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getNotes()
    {
        return $this->notes;
    }

    public function setNotes($notes)
    {
        $this->notes = $notes;
    }
}
