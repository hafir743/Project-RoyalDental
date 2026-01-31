<?php
class User
{
    private $conn;
    private $table_name = 'users';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function register($name, $surname, $email, $password, $license_number = null, $phone = null, $clinic_name = null, $specialization = null, $address = null, $city = null)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Invalid email format'];
        }

        $checkQuery = "SELECT id FROM {$this->table_name} WHERE email = :email";
        $checkStmt = $this->conn->prepare($checkQuery);
        $checkStmt->bindParam(':email', $email);
        $checkStmt->execute();

        if ($checkStmt->rowCount() > 0) {
            return ['success' => false, 'message' => 'Email already exists'];
        }

        if (strlen($password) < 6) {
            return ['success' => false, 'message' => 'Password must be at least 6 characters'];
        }

        $query = "INSERT INTO {$this->table_name} (name, surname, email, password, role, license_number, phone, clinic_name, specialization, address, city) 
                  VALUES (:name, :surname, :email, :password, 'user', :license_number, :phone, :clinic_name, :specialization, :address, :city)";

        $stmt = $this->conn->prepare($query);

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':surname', $surname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':license_number', $license_number);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':clinic_name', $clinic_name);
        $stmt->bindParam(':specialization', $specialization);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':city', $city);

        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Registration successful'];
        }
        return ['success' => false, 'message' => 'Registration failed'];
    }

    public function login($email, $password)
    {
        $query = "SELECT id, name, surname, email, password, role FROM {$this->table_name} WHERE email = :email";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $row['password'])) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['name'] . ' ' . $row['surname'];
                $_SESSION['user_email'] = $row['email'];
                $_SESSION['user_role'] = $row['role'];
                return ['success' => true, 'role' => $row['role']];
            }
        }
        return ['success' => false, 'message' => 'Invalid email or password'];
    }

    public function getUserById($id)
    {
        $query = "SELECT * FROM {$this->table_name} WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    public function isAdmin()
    {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();
    }
}