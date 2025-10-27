<?php
    require_once 'BaseController.php';

    class ApiController extends BaseController {
        public function run() {
            // very simple API dispatcher based on 'resource' and 'id'
            $resource = $_GET['resource'] ?? null;
            $id = $_GET['id'] ?? null;
            if ($resource === 'produits') {
                $ctrl = new ProduitController();
                if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                    if ($id) $ctrl->api_show($id);
                    else $ctrl->api_list();
                } else {
                    $this->json(['error' => 'Method not allowed'], 405);
                }
            } else {
                $this->json(['error' => 'Resource not found'], 404);
            }
        }
    }
