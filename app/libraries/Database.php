<?php

class Database
{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $pdo;
    private $stmt;

    public function __construct()
    {
        $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbname;
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        try {
            $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            die('Connection failed: ' . $e->getMessage());
        }
    }

    /**
     * Prepares the SQL statement.
     * @param string $sql The SQL query.
     */
    public function query($sql)
    {
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->setFetchMode(PDO::FETCH_ASSOC); 
        return $this;
    }

    /**
     * Binds a value to a placeholder in the prepared statement.
     * @param string $param The placeholder (e.g., ':id').
     * @param mixed $value The value to bind.
     * @param int|null $type The PDO data type.
     */
    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            $type = match (true) {
                is_int($value) => PDO::PARAM_INT,
                is_bool($value) => PDO::PARAM_BOOL,
                is_null($value) => PDO::PARAM_NULL,
                default => PDO::PARAM_STR,
            };
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    /**
     * Executes the prepared statement.
     * @return bool True on success, false on failure.
     */
    public function execute()
    {
        return $this->stmt->execute();
    }


    public function single() {
    $this->execute();
    return $this->stmt->fetch(PDO::FETCH_OBJ);
}

    /**
     * Returns a single result as an associative array.
     * @return mixed
     */
    public function fetch()
    {
        return $this->stmt->fetch();
    }

    /**
     * Returns all results as an array of associative arrays.
     * @return array
     */
    public function findAll()
    {
        return $this->stmt->fetchAll();
    }
    
    /**
     * Returns the ID of the last inserted row.
     * @return string
     */
    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

    //------------------------------------------
    // Corrected CRUD Methods using fetch() and findAll()
    //------------------------------------------

    /**
     * Creates a new record in a specified table.
     * @param string $table The name of the table.
     * @param array $data An associative array of column-value pairs.
     * @return bool True on success, false on failure.
     */
    public function create($table, $data)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO `$table` ($columns) VALUES ($placeholders)";
        $this->query($sql);

        foreach ($data as $key => $value) {
            $this->bind(":$key", $value);
        }

        return $this->execute();
    }

    /**
     * Retrieves all records from a specified table.
     * @param string $table The name of the table.
     * @return array An array of associative arrays representing the records.
     */
    public function readAll($table)
    {
        $sql = "SELECT * FROM `$table`";
        $this->query($sql);
        $this->execute();
        return $this->findAll();
    }

    /**
     * Retrieves a single record by a column and its value.
     * @param string $table The name of the table.
     * @param string $column The column to search on.
     * @param mixed $value The value to search for.
     * @return array|false An associative array of the record, or false if not found.
     */
    public function find($table, $column, $value)
    {
        $sql = "SELECT * FROM `$table` WHERE `$column` = :value LIMIT 1";
        $this->query($sql);
        $this->bind(':value', $value);
        $this->execute();
        return $this->fetch();
    }
    /**
 * Retrieves all records that match a column value.
 * @param string $table
 * @param string $column
 * @param mixed $value
 * @return array
 */
public function findAllBy($table, $column, $value)
{
    $sql = "SELECT * FROM `$table` WHERE `$column` = :value";
    $this->query($sql);
    $this->bind(':value', $value);
    $this->execute();
    return $this->findAll();
}


    /**
     * Retrieves a single record by its primary key (id).
     * @param string $table The name of the table.
     * @param int $id The ID of the record.
     * @return array|false An associative array of the record, or false if not found.
     */
    public function getById($table, $id)
    {
        return $this->find($table, 'id', $id);
    }


    





    /**
     * Updates an existing record in a specified table.
     * @param string $table The name of the table.
     * @param int $id The ID of the record to update.
     * @param array $data An associative array of column-value pairs to update.
     * @return bool True on success, false on failure.
     */
    public function update($table, $id, $data)
    {
        $set = [];
        foreach ($data as $key => $value) {
            $set[] = "`$key` = :$key";
        }
        $set = implode(', ', $set);
        $sql = "UPDATE `$table` SET $set WHERE `id` = :id";
        $this->query($sql);

        foreach ($data as $key => $value) {
            $this->bind(":$key", $value);
        }
        $this->bind(':id', $id);

        return $this->execute();
    }

   
    public function delete($table, string $column, int $value) {
    $this->query("DELETE FROM $table WHERE $column = :value");
    $this->bind(':value', $value);
    return $this->execute();
}

    public function columnFilter($table, $column, $value)
    {
        $sql = "SELECT * FROM `$table` WHERE `$column` = :value";
        $this->query($sql);
        $this->bind(':value', $value);
        $this->execute();
        return $this->fetch();
    }


    public function loginCheck($email, $password)
    {
        $sql = "SELECT * FROM users WHERE email = :email AND password = :password";
        $this->query($sql);
        $this->bind(':email', $email);
        $this->bind(':password', $password);
        $this->execute();
        return $this->fetch();
    }

      public function setLogin($id)
    {
        $sql = "UPDATE users SET `is_login` = 1 WHERE `id` = :id";
        $this->query($sql);
        $this->bind(':id', $id);
        return $this->execute();
    }

     public function unsetLogin($id)
    {
        $sql = "UPDATE users SET `is_login` = 0 WHERE `id` = :id";
        $this->query($sql);
        $this->bind(':id', $id);
        return $this->execute();
    }

     public function findByEmail($table, $email)
    {
        $query = "SELECT * FROM $table WHERE email = :email LIMIT 1";
        $this->query($query);
        $this->bind(':email', $email);
        $this->execute();
        return $this->fetch();
    }


    // Retrieve Total Orders from database
    public function countAll($table) {
    $this->query("SELECT COUNT(*) as total FROM $table");
    $row = $this->single(); 
    return $row->total;
}

/**
 * Finds a single user by either email or phone number.
 * @param string $email
 * @param string $phoneNumber
 * @return array|false An associative array of the user record, or false if not found.
 */
public function findUserByCredentials($email, $phoneNumber)
{
    $sql = "SELECT * FROM `users` WHERE `email` = :email OR `phone_number` = :phone_number LIMIT 1";
    $this->query($sql);
    $this->bind(':email', $email);
    $this->bind(':phone_number', $phoneNumber);
    $this->execute();
    return $this->fetch();
}



public function getProductsByCategoryId($categoryId)
{
    $this->query("SELECT * FROM products WHERE category_id = :id");
    $this->bind(':id', $categoryId);
    return $this->resultSet(); // Assumes this method returns an array of results
}

public function resultSet()
{
    
    $this->stmt->execute();
    return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
}


/**
 * Retrieves a specified number of records from a table,
 * ordered by a given column.
 * @param string $table The name of the table.
 * @param int $limit The number of records to retrieve.
 * @param string $orderBy The column to order the results by.
 * @param string $order The order direction ('ASC' or 'DESC').
 * @return array An array of associative arrays representing the records.
 */
public function getRecent($table, $limit, $orderBy = 'created_at', $order = 'DESC')
{
    $sql = "SELECT * FROM `$table` ORDER BY `$orderBy` $order LIMIT :limit";
    $this->query($sql);
    $this->bind(':limit', $limit, PDO::PARAM_INT);
    $this->execute();
    return $this->findAll();
}

public function getLastError() {
    return $this->pdo->errorInfo();
}


public function columnFilterMultiple($table, $filters = [])
{
    if(empty($filters)) return [];

    $sql = "SELECT * FROM $table WHERE ";
    $params = [];
    $conditions = [];

    foreach($filters as $column => $value){
        $conditions[] = "$column = :$column";
        $params[":$column"] = $value;
    }

    $sql .= implode(" AND ", $conditions);

    $this->query($sql);
    foreach($params as $key => $val){
        $this->bind($key, $val);
    }

    return $this->resultSet(); // fetch all rows
}


public function beginTransaction()
{
    return $this->pdo->beginTransaction();
}

public function commit()
{
    return $this->pdo->commit();
}

public function rollBack()
{
    return $this->pdo->rollBack();
}




    
}