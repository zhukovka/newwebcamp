<?php

abstract class Mapper {
    public function mapArray($rowArray) {
        $ret = array();

        foreach($rowArray as $row) {
            array_push($ret, $this->map($row));
        }
    }

    public abstract function map($row);
}

abstract class Repository {
    private $mapper;

    function __construct($mapper) {
        $this->mapper = $mapper;
    }

    function getMapper() {
        return $this->mapper;
    }
}
