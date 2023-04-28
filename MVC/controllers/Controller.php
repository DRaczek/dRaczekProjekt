<?php

class Controller{
    public function __construct(){

    }

    /**
     * Funkcja do ładowania widoków
     * @param $name Nazwa Widoku
     * @param $data opcjonalne dane wymagane do utworzenia widoku
     * @param $return flaga, która decyduje czy dane są buforowane i zwracane, czy bezpośrednio wyświetlane na ekranie.
     */
    public function loadView($name, $data, $return){
        //ob_start() zaczyna buforowanie, do tego momentu wszysto co byłoby wypisane na ekranie użytkownika jest przechowywane w buforze
        if($return===true)ob_start();
        include($name.".php");
        if($return===true){
            //zwracana jest zawartość buforu jeżeli flaga $return===true
           return ob_get_clean();
        }
    }
}