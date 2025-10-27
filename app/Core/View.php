<?php
namespace App\Core;

class View {

    /**
     * Layout par défaut pour le front office
     */
    private const DEFAULT_FRONT_LAYOUT = 'layouts/front';

    /**
     * Layout par défaut pour le dashboard/admin
     */
    private const DEFAULT_ADMIN_LAYOUT = 'layouts/admin';

    /**
     * Affiche une vue avec des données passées
     * et l'injecte dans un layout.
     *
     * @param string $view Nom de la vue, ex: 'home/accueil'
     * @param array $data Variables à passer à la vue
     * @param string|null $layout Layout à utiliser. Si null, layout par défaut selon type
     * @param string $type 'front' ou 'admin'
     */
    public static function render(string $view, array $data = [], ?string $layout = null, string $type = 'front'): void
    {
        // Nettoyer le nom de la vue pour éviter les "../"
        $view = str_replace(['..', '\\'], '', $view);
        $viewPath = dirname(__DIR__) . "/Views/{$view}.php";

        if (!file_exists($viewPath)) {
            throw new \Exception("La vue '{$view}' est introuvable : {$viewPath}");
        }

        // Extraire les variables pour qu'elles soient accessibles dans la vue
        extract($data);

        // Capturer le contenu de la vue
        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        // Déterminer le layout à utiliser
        if ($layout === null) {
            $layout = $type === 'admin' ? self::DEFAULT_ADMIN_LAYOUT : self::DEFAULT_FRONT_LAYOUT;
        }

        $layoutPath = dirname(__DIR__) . "/Views/{$layout}.php";
        if (!file_exists($layoutPath)) {
            throw new \Exception("Le layout '{$layout}' est introuvable : {$layoutPath}");
        }

        require $layoutPath;
    }
}
