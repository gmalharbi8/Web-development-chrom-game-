<?php
class Database
{
    private static $host = "127.0.0.1";
    private static $username = "root";
    private static $password = "";
    private static $databaseName = "crash_game";
    private static $dbConnection;

    public static function connect()
    {
        self::$dbConnection = mysqli_connect(self::$host, self::$username, self::$password);
        if (self::$dbConnection) {
            return mysqli_select_db(self::$dbConnection, self::$databaseName) ? true : false;
        }
        return $dbConnection ? true : false;
    }

    public static function select($selectItems, $tableName, $whereClause)
    {
        if (!$selectItems || !$tableName) {
            return null;
        }
        $query = "SELECT " . $selectItems . " FROM " . $tableName . ($whereClause ? " " . $whereClause : "");
        $result = mysqli_query(self::$dbConnection, $query);
        return $result;
    }

    // insert("table_name", "column1, column2, column3", [["val1", "val2", "val3"], ["val1", "val2", "val3"]])
    // insert INTO table_name (column1, column2, column3) VALUES ('val1', 'val2', 'val3'), ('val1', 'val2', 'val3')
    public static function insert($tableName, $columnsNames, $values)
    {
        $valuesDbStructure = "";
        $numberOfElements = count($values);
        foreach ($values as $key => $value) {
            $temp = "('";
            $temp .= implode("', '", $value);
            $temp .= "')";
            $valuesDbStructure .= $temp . ($key < ($numberOfElements - 1) ? ", " : "");
        }
        $query = "INSERT INTO " . $tableName . " (" . $columnsNames . ") VALUES " . $valuesDbStructure;
        $result = mysqli_query(self::$dbConnection, $query);
        return $result;
    }

    public static function close()
    {
        if (self::$dbConnection) {
            self::$dbConnection->close();
        }
    }
}
