<?php

class DashboardController
{
    public function index()
    {
        if(!isset($_SESSION['user'])) {
            header('Location: /user/login');
            exit();
        }

        $userName = $_SESSION['user']->getUsername();
        include '../views/dashboard/index.php';
    }

    public function agenda()
    {
        if(!isset($_SESSION['user'])) {
            header('Location: /user/login');
            exit();
        }

        $userName = $_SESSION['user']->getUsername();
        include '../views/dashboard/agenda.php';
    }
}
