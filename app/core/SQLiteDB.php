<?php

class SQLiteDB
{
    private $path = "";
    private $name = "";

    public function __construct($name = null, $path = null)
    {
        if ($name === null) {
            $this->name = Config::get('DB_NAME');
        } else {
            $this->name = $name;
        }
        if ($path === null) {
            $this->path = Config::get('PATH_DB');
        } else {
            $this->path = $path;
        }
    }

    public function getNewConnection()
    {
        $connection = false;
        try {
            $db_file = $this->path.$this->name.'.db';
            $db_file_exists = file_exists($db_file);
            $connection = new PDO('sqlite:' . $db_file);

            if (!$db_file_exists) {
                $is_init_success = $this->createTables($connection);
                if (!$is_init_success) {
                    Feedback::add('ERR', 'Failed to initialize new database.');
                }
            }
            //explict errors for debug purposes
            //$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            Feedback::add('ERR', 'PDO database connection problem: '.$e->getMessage());
        } catch (Exception $e) {
            Feedback::add('ERR', $e->getMessage());
        }
        return $connection;
    }

    private function createTables($connection) {
    // TODO: Add ALTER TABLE functionality if Table exists, but columns don't match
		$sql = "CREATE TABLE IF NOT EXISTS user
		        (id INTEGER PRIMARY KEY AUTOINCREMENT,
                username TEXT UNIQUE,
                email TEXT UNIQUE,
                full_name TEXT,
                password TEXT,
                last_login_timestamp TEXT);";
		return $connection->query($sql);
	}
}