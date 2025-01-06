<?php

namespace App\Models;

class Tag {
    private $pdo;

    // Constructor to initialize PDO connection
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

   
}
?>

