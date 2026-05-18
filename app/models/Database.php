<?php

class Database {
    private $host = "localhost";
    private $db_name = "carrate_db"; // ZMĚNĚNO: Nový název naší databáze
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        
        // Odpojí připojení k databázi tím, že změní proměnnou $this->conn na null.
        $this->conn = null;
        
        try {
            // PDO – Bezpečné a univerzální připojení k databázi
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4", $this->username, $this->password);
            
            // Nastavení vyhazování výjimek při chybě
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // TESTOVACÍ VÝPIS JSME SMAZALI (aby nám to nerozbilo aplikaci v budoucnu)
            
        } catch (PDOException $exception) {
            // Tohle echo tu nechat můžeme, protože když databáze spadne, stejně chceme vidět proč
            echo "Chyba připojení: " . $exception->getMessage();
        }
        return $this->conn;
    }
}

// TESTOVACÍ KÓD NA KONCI JSME TAKÉ SMAZALI/ZAKOMENTOVALI
// (Třídu Database budeme volat až v našich controllerech)