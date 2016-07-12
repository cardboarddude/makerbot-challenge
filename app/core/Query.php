<?php

class Query {

    private $tableName;
    private $select = "";
    private $where = "";
    private $limit = "";
    private $insert = "";

    private $db = null;
    private $sql = null;
    private $query = null;
    private $connection = null;
    private $isExecSuccess = false;

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

    public function prepare($bind_names, $bind_values) {
        $this->sql = $this->select . $this->where . $this->limit . $this->insert . ';';
        $this->connection = $this->db->getNewConnection();

        try {
            $this->query = $this->connection->prepare($this->sql);
            if (!empty($bind_values)) {
                for ($i = 0; $i < sizeof($bind_names); $i++) {
                    $this->query->bindValue(':'.$bind_names[$i], $bind_values[$i]);
                }
            }
        } catch (Exception $e) {
            Feedback::add('ERR', $e->getMessage());
        }
    }

    public function execute() {
        $this->isExecSuccess = $this->query->execute();
    }

    public function isSuccess() {
        return $this->isExecSuccess;
    }

    public function getResult() {
        if ($this->result == null && $this->query != null) {
            $this->result = $this->query->fetchObject();
            //var_dump($this->sql);
            $this->connection = null;
            $this->query = null;
        }
        return $this->result;
    }

    public function isFieldValueTaken($field_names, $field_values) {
        $this->selectCols($field_names);
        $this->whereColsEqual($field_names, $field_values);
        $this->limit(1);
        $this->prepare($field_names, $field_values);
        $this->execute();

        if ($this->isSuccess()) {
            return $this->getResult() && (count($this->getResult()) > 0);
        }
    }
}