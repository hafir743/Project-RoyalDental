<?php
class Service
{
    private $conn;
    private $table_name = 'services';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    private function generateSlug($name)
    {
        $slug = strtolower(trim($name));
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        return trim($slug, '-');
    }

    public function create($name, $description, $image = null, $status = 'active', $user_id)
    {
        $slug = $this->generateSlug($name);

        $query = "INSERT INTO {$this->table_name} (name, slug, description, image, status, created_by, updated_by) 
                  VALUES (:name, :slug, :description, :image, :status, :created_by, :updated_by)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':slug', $slug);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':created_by', $user_id);
        $stmt->bindParam(':updated_by', $user_id);

        if ($stmt->execute()) {
            return ['success' => true, 'id' => $this->conn->lastInsertId()];
        }
        return ['success' => false, 'message' => 'Failed to create service'];
    }

    public function update($id, $name, $description, $image = null, $status = 'active', $user_id)
    {
        $slug = $this->generateSlug($name);

        $query = "UPDATE {$this->table_name} SET name = :name, slug = :slug, description = :description, 
                  status = :status, updated_by = :updated_by";

        if ($image !== null) {
            $query .= ", image = :image";
        }

        $query .= " WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':slug', $slug);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':updated_by', $user_id);

        if ($image !== null) {
            $stmt->bindParam(':image', $image);
        }

        return $stmt->execute();
    }

    public function getAll()
    {
        $query = "SELECT s.*, 
                  u1.name as created_by_name, u1.surname as created_by_surname,
                  u2.name as updated_by_name, u2.surname as updated_by_surname
                  FROM {$this->table_name} s
                  LEFT JOIN users u1 ON s.created_by = u1.id
                  LEFT JOIN users u2 ON s.updated_by = u2.id
                  ORDER BY s.created_at DESC";
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

    public function delete($id)
    {
        $query = "DELETE FROM {$this->table_name} WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getActive()
    {
        $query = "SELECT * FROM {$this->table_name} WHERE status = 'active' ORDER BY name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}