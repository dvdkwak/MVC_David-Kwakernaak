<?php

// class for a database connection
class db
{
    // **PROPERTIES**
    private $host     = "localhost";
    private $username = "root";
    private $password = "usbw";
    private $database = "ezctrl";


    // **METHODS**

    // connect() => mysqli (obj)
    public function connect()
    {
        $mysqli = new mysqli($this->host, $this->username, $this->password, $this->database);
        return $mysqli;
    }
}
