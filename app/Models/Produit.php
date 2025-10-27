<?php
    namespace App\Models;
    use App\Models\BaseModel;

    class Produit extends BaseModel {
        protected $table = 'produits';

        public function getAll() {
            $query = $this->db->query("SELECT * FROM {$this->table}");
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getById($id) {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }
