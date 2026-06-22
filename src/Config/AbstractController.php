<?php
namespace App\Config;

abstract class AbstractController {
    protected function __construct() {}

    public function render(string $view, array $data = []): void {
        extract($data);
        
        $file = dirname(__DIR__) . "/Views/" . $view . ".php";
        
        if (file_exists($file)) {
            require_once $file;
        } else {
            echo "<h3>Erreur : Le fichier de vue n'existe pas :</h3>";
            echo "<p>" . htmlspecialchars($file) . "</p>";
        }
    }
}