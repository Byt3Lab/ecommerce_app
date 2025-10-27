<?php
    namespace App\Controllers;
    use App\Controllers\BaseController;
    use App\Models\Produit;

    class ProduitController extends BaseController {
        public function index() {
            $model = new Produit();
            $produits = $model->all();
            $this->render('produit/index', ['produits' => $produits]);
        }

        public function create() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $name = $_POST['nom'] ?? '';
                $prix = $_POST['prix'] ?? 0;
                $model = new Produit();
                $id = $model->create(['nom' => $name, 'prix' => $prix]);
                header('Location: ?controller=Produit&action=index');
                exit;
            }
            $this->render('produit/create', []);
        }

        public function show($id) {
            $model = new Produit();
            $produit = $model->find($id);
            $this->render('produit/show', ['produit' => $produit]);
        }

        public function api_list() {
            $model = new Produit();
            $this->json($model->all());
        }

        public function api_show($id) {
            $model = new Produit();
            $p = $model->find($id);
            if (!$p) {
                $this->json(['error' => 'Not found'], 404);
            }
            $this->json($p);
        }
    }
