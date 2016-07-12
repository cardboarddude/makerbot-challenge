<?php

class Query {

    private $db;
    private $tableName;
    private $select = "";
    private $where = "";
    private $limit = "";
    private $insert = "";

    private $query;

    public function __construct($table_name) {
        $this->tableName = $table_name;
        $this->db = new SQLiteDB();
    }

    public function selectCols($col_names) {
        $this->select = QueryFactory::buildSelect($this->tableName, $col_names);
    }

    public function whereColsEqual($col_names) {
        $equal_operators = array_pad([],sizeof($col_names),'=');
        $this->where = QueryFactory::buildWhere($col_names, $equal_operators, 'OR');
    }

    public function limit($limit_num) {
        $this->limit = QueryFactory::buildLimit($limit_num);
    }

    public function insert($col_names) {
        $this->insert = QueryFactory::buildInsert($this->tableName, $col_names);
    }

    public function prepareAndExecute($bind_names, $bind_values) {
        $sql = $this->select . $this->where . $this->limit . $this->insert . ';';
        $connection = $this->db->getNewConnection();
        $is_success = false;
        try {
            $this->query = $connection->prepare($sql);
            if (!empty($bind_values)) {
                for ($i = 0; $i < sizeof($bind_names); $i++) {
                    $this->query->bindValue(':'.$bind_names[$i], $bind_values[$i]);
                }
            }
            $is_success = $this->query->execute();
        } catch (Exception $e) {
            Feedback::add('ERR', $e->getMessage());
        }
        $connection = null;

        return ($is_success ? $this->query->fetchObject() : false);
    }

    public function isFieldValueTaken($field_names, $field_values) {
        $this->selectCols($field_names);
        $this->whereColsEqual($field_names, $field_values);
        $this->limit(1);
        $result = $this->prepareAndExecute($field_names, $field_values);

        return is_object($result);
    }
}