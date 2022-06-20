<?php

abstract class AbstractRepository
{

    private const DATABASE_NAME = "mysql:host=localhost;port=3306;dbname=test_sql";
    private const DATABASE_USERNAME = "root";
    private const DATABASE_PASSWORD = "root";

    /**
     * Initialise PDO connection with database
     */
    private function connect()
    {
        return new PDO(self::DATABASE_NAME, self::DATABASE_USERNAME, self::DATABASE_PASSWORD);
    }

    /**
     * @param string $query Request in SQL
     * @param array $params Params [":variableSQL" => "valeur",...]
     * @return query result
     */
    protected function executeQuery(string $query, string $class, array $params = []):array
    {
        $conn = $this->connect();
        $result = $conn->prepare($query);
        foreach ($params as $key => $param) $result->bindValue($key, $param);
        $result->execute();
        $conn = null;
        return $result->fetchAll(PDO::FETCH_CLASS, $class);
    }
}
