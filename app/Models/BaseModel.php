<?php
    namespace App\Models;
    use App\Core\Database;
    //require_once __DIR__ . '/../Core/Database.php';

    class BaseModel {
        protected $db;
        protected $table;

        public function __construct() {
            $this->db = Database::getConnection();
        }

        public function all() {
            $stmt = $this->db->query("SELECT * FROM {$this->table}");
            return $stmt->fetchAll();
        }

        public function find($id) {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
            $stmt->execute(['id' => $id]);
            return $stmt->fetch();
        }

        public function create($data) {
            $columns = implode(',', array_keys($data));
            $placeholders = implode(',', array_map(function($k){ return ':' . $k; }, array_keys($data)));
            $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
            $stmt = $this->db->prepare($sql);
            $stmt->execute($data);
            return $this->db->lastInsertId();
        }

        public function update($id, $data) {
            $pairs = implode(',', array_map(function($k){ return "{$k}=:{${k}}"; }, array_keys($data)));
            // Above line uses complex string, simpler approach below
            $pairs = implode(',', array_map(function($k){ return "{$k}=:" . $k; }, array_keys($data)));
            $data['id'] = $id;
            $sql = "UPDATE {$this->table} SET {$pairs} WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute($data);
        }

        public function delete($id) {
            $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
            return $stmt->execute(['id' => $id]);
        }
    }
