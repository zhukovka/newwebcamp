<?php
abstract class Repository {
    private $tableName;

    function __construct($tableName) {
        $this->tableName = $tableName;
    }

    public function SelectAll() {
        return $this->mapObjects(Database::fetch($this->selectExpression()));
    }

    public function SelectOne($id) {
        return $this->mapObject(Database::fetchOne($this->selectOneExpression($id)));
    }

    public function Update($obj) {
        Database::modifyOne($this->updateExpression($obj));
    }

    public function Delete($id) {
        Database::modifyOne($this->deleteExpression($id));
    }

    private function selectExpression() {
        return "SELECT ".implode(", ", $this->getRows())." FROM {$this->tableName}";
    }

    private function selectOneExpression($id) {
        return $this->selectExpression()." WHERE Id = ".$this->qouteString($id);
    }

    private function updateExpression($obj) {
        $rows = $this->mapRows($obj);
        $ret =  "UPDATE {$this->tableName} SET ";
        foreach($rows as $value => $key) {
            $ret .= "{$key} = ".$this->qouteString($value);
        }
        return $ret;
    }

    private function deleteExpression($id) {
        return "DELETE FROM {$this->tableName} WHERE Id = ".$this->qouteString($id);
    }

    private function qouteString($value) {
        if(is_string($value)) return "'{$value}'";
        return $value;
    }

    protected function mapObjects($rowArray) {
        $ret = array();

        foreach($rowArray as $row) {
            array_push($ret, $this->mapObject($row));
        }
        return $ret;
    }

    public abstract function getRows();

    public abstract function mapObject($row);

    public abstract function mapRows($obj);
}
