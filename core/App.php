<?php

class App {
    // Výchozí nastavení - pokud uživatel přijde na hlavní stránku a nezadá URL,
    // automaticky se načte BookController a jeho metoda index()
    protected $controller = 'BookController';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        // Zavoláme pomocnou funkci, která nám rozseká URL na pole
        $url = $this->parseUrl();

        // 1. KONTROLER (např. url=book/...)
        // $url[0] by mělo obsahovat 'book'. My z toho potřebujeme udělat 'BookController'
        if (isset($url[0])) {
            $controllerName = ucfirst($url[0]) . 'Controller'; // ucfirst zvětší první písmeno
            
            // Zkontrolujeme, jestli takový soubor s kontrolerem vůbec existuje
            if (file_exists('../app/controllers/' . $controllerName . '.php')) {
                $this->controller = $controllerName;
                unset($url[0]); // Smažeme z pole, už jsme to zpracovali
            }
        }

        // Načteme soubor kontroleru a vytvoříme z něj objekt (instanci)
        require_once '../app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // 2. METODA (např. url=book/create)
        // $url[1] by mělo obsahovat 'create' nebo 'store' atd.
        if (isset($url[1])) {
            // Zkontrolujeme, jestli v našem kontroleru taková metoda (funkce) existuje
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]); // Smažeme z pole
            }
        }

        // 3. PARAMETRY (např. id knihy pro smazání: url=book/delete/5)
        // Pokud v poli $url ještě něco zbylo, jsou to parametry. Jinak je to prázdné pole.
        $this->params = $url ? array_values($url) : [];

        // 4. SPUŠTĚNÍ METODY
        // Tato kouzelná funkce v PHP vezme vybraný kontroler, zavolá na něm vybranou metodu
        // a předá jí případné parametry.
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    // Pomocná metoda pro rozsekání URL
    public function parseUrl() {
        if (isset($_GET['url'])) {
            // Odstraní případné lomítko na konci, vyčistí URL od nebezpečných znaků
            // a nakonec ji rozsekne podle lomítek do pole
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return []; // Pokud URL v adrese není, vrátí prázdné pole
    }
}