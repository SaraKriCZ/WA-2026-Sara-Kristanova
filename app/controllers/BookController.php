<?php

class BookController {

//úvodní stránka
public function idex() {

//načte se pouze připravený soubor s HTML strukturou
    require_once '../app/views/books/books_list.php';
}
}