<?php
class Contact
{
    private $conn;
    private $table_name = 'contact_messages';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create($name, $email, $phone, $subject, $message)
    {
        $query = "INSERT INTO {$this->table_name} (name, email, phone, subject, message) 
                  VALUES (:name, :email, :phone, :subject, :message)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':message', $message);

        if ($stmt->execute()) {
            return ['success' => true, 'id' => $this->conn->lastInsertId()];
        }
        return ['success' => false, 'message' => 'Failed to save message'];
    }

    public function getAll()
    {
        $query = "SELECT * FROM {$this->table_name} ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $query = "SELECT * FROM {$this->table_name} WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function updateStatus($id, $status)
    {
        $query = "UPDATE {$this->table_name} SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':status', $status);
        return $stmt->execute();
    }

    public function delete($id)
    {
        $query = "DELETE FROM {$this->table_name} WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getUnreadCount()
    {
        $query = "SELECT COUNT(*) as count FROM {$this->table_name} WHERE status = 'new'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['count'];
    }
}

class Appointment
{
    private $conn;
    private $table_name = 'appointments';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create($name, $email, $phone, $service, $color, $tooth_shape, $preferred_date, $preferred_time, $notes, $files = null)
    {
        $query = "INSERT INTO {$this->table_name} (name, email, phone, service, color, tooth_shape, preferred_date, preferred_time, notes, files) 
                  VALUES (:name, :email, :phone, :service, :color, :tooth_shape, :preferred_date, :preferred_time, :notes, :files)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':service', $service);
        $stmt->bindParam(':color', $color);
        $stmt->bindParam(':tooth_shape', $tooth_shape);
        $stmt->bindParam(':preferred_date', $preferred_date);
        $stmt->bindParam(':preferred_time', $preferred_time);
        $stmt->bindParam(':notes', $notes);
        $stmt->bindParam(':files', $files);

        if ($stmt->execute()) {
            return ['success' => true, 'id' => $this->conn->lastInsertId()];
        }
        return ['success' => false, 'message' => 'Failed to save appointment'];
    }

    public function getAll()
    {
        $query = "SELECT * FROM {$this->table_name} ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $query = "SELECT * FROM {$this->table_name} WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function updateStatus($id, $status)
    {
        $query = "UPDATE {$this->table_name} SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':status', $status);
        return $stmt->execute();
    }

    public function delete($id)
    {
        $query = "DELETE FROM {$this->table_name} WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}