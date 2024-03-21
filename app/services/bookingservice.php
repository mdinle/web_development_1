<?php
namespace App\Services;

use App\Repositories\BookingRepository;

class BookingService
{

    private $bookingRepo;

    public function __construct()
    {
        $this->bookingRepo = new BookingRepository();
    }

    public function createBooking($booking)
    {
        return $this->bookingRepo->insert($booking);
    }

    public function getAllTrainers()
    {
        return $this->bookingRepo->getAllTrainers();
    }

    public function getBookingsByTrainer($trainer_id)
    {
        return $this->bookingRepo->getBookingsByTrainer($trainer_id);
    }

    public function getBookingsByClient($client_id)
    {
        return $this->bookingRepo->getBookingsByClient($client_id);
    }

    public function updateBooking($booking)
    {
        return $this->bookingRepo->updateBooking($booking);
    }

    public function deleteBooking($booking_id)
    {
        return $this->bookingRepo->deleteBooking($booking_id);
    }
}
