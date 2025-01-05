<?php
namespace App\Models;
use PDO;
class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function getPdo() {
        return $this->pdo;
    }

    public function register($username, $email, $password) {
    
        if (empty($username) || empty($email) || empty($password)) {
            throw new Exception("All fields are required.");
        }
    
    
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            throw new Exception("Email already exists.");
        }
    
    
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        
        $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
    
        if ($stmt->execute()) {
            return true; 
        } else {
            throw new Exception("Database insertion failed."); 
        }
    }
    
    

     //  function to find user by email
     public function findByUsername($username) {
    $query = "SELECT * FROM users WHERE username = :username LIMIT 1";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

    // Method to validate the user login credentials
    public function login($email, $password) {
        // Validate the input data
        if (empty($email) || empty($password)) {
            throw new Exception("Email and password are required.");
        }

        // Fetch the user data from the database
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user; // Return user data if credentials are correct
        } else {
            throw new Exception("Invalid email or password.");
        }
    }

    // Method to get user data by ID
    public function getUserById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

?>