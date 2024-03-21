<?php
namespace App\Models;

class Details
{
    private $id;
    private $fullName;
    private $age;
    private $gender;
    private $address;
    private $phonenumber;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getFullName()
    {
        return $this->fullName;
    }

    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
    }

    public function getAge()
    {
        return $this->age;
    }

    public function setAge($age)
    {
        $this->age = $age;
    }

    public function getGender()
    {
        return $this->gender;
    }
    
    public function setGender($gender)
    {
        $this->gender = $gender;
    }
        
    public function getAddress()
    {
        return $this->address;
    }
        
    public function setAddress($address)
    {
        $this->address = $address;
    }
        
    public function getPhonenumber()
    {
        return $this->phonenumber;
    }
        
    public function setPhonenumber($phonenumber)
    {
        $this->phonenumber = $phonenumber;
    }
}
