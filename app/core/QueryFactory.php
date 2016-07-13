<?php

class QueryFactory {

    public static function buildSelect($table, $col_names) {
        $sql = ' SELECT ';

        if (!empty($col_names)) {
            $sql .= self::buildSeparatedString($col_names,',');
        } else {
            $sql .= ' * ';
        }

        $sql .= ' FROM '.$table;
        return $sql;
    }


    public static function buildWhere($col_names, $comparison_ops, $logical_op = 'AND') {
        if (!self::areSameSize(array($col_names, $comparison_ops))) {
            return '';
        }

        $sql = ' WHERE ';

        for ($i = 0; $i < sizeof($col_names); $i++) {
            $col_names[$i] .= ' '.$comparison_ops[$i].' :'.$col_names[$i];
        }

        $sql .= self::buildSeparatedString($col_names,$logical_op);

        return $sql;
    }

    public static function buildLimit($limit_num) {
        return ' LIMIT '.$limit_num;
    }

    public static function buildInsert($table, $col_names) {
        $sql = " INSERT INTO $table (";
        $sql .= self::buildSeparatedString($col_names,',');
        $sql .= ") VALUES(";
        for ($i = 0; $i < sizeof($col_names); $i++) {
            $col_names[$i] = ':'.$col_names[$i];
        }
        $sql .= self::buildSeparatedString($col_names,',');
        $sql .= ')';
        return $sql;
    }

    public static function buildUpdate($table, $col_names) {
        $sql = " UPDATE $table SET ";

        for ($i = 0; $i < sizeof($col_names); $i++) {
            $col_names[$i] = $col_names[$i].' = :'.$col_names[$i];
        }

        $sql .= self::buildSeparatedString($col_names,$logical_op);

        return $sql;
    }

    private static function buildSeparatedString($list_items, $delimeter) {
        $delimeter_separated_string = "";
        for ($i = sizeof($list_items) - 1; $i >= 0; $i--) {
            $delimeter_separated_string .= $list_items[$i];

            if ($i > 0) {
                $delimeter_separated_string .= ' '. $delimeter .' ';
            }
        }
        return $delimeter_separated_string;
    }

    private static function areSameSize($list_of_arrays) {
        $size = -1;
        foreach ($list_of_arrays as $array) {
            if ($size == -1) {
                $size = sizeof($array);
            } else if ($size != sizeof($array)) {
                return false;
            }
        }

        return true;
    }

}