<?php


class Paciente {
    private $numSS;
    
    function __construct($numSS=null) {
        $this->numSS = $numSS;
    }
    function getNumSS() {
        return $this->numSS;
    }

    function setNumSS($numSS) {
        $this->numSS = $numSS;
    }

}
