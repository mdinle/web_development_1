<?php
namespace App\Repositories;

use PDO;

class Repository
{
    protected $db;

    public function __construct()
    {
        require __DIR__ . '/../config/dbconfig.php';

        try {
            $this->db = new PDO("$type:host=$servername;dbname=$dbname", $username, $password);
            // set the PDO error mode to exception
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}
