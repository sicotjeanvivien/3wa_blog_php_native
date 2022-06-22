<?php

use LDAP\Result;

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
    protected function executeQuery(string $query, string $class, array $params = []): mixed
    {
        $conn = $this->connect();
        $stm = $conn->prepare($query);
        foreach ($params as $key => $param) $stm->bindValue($key, $param);
        $stm->execute();
        $conn = null;

        $result = null;
        
        $stm->setFetchMode(PDO::FETCH_CLASS, $class);

        if ($stm->rowCount() === 1) $result = $stm->fetch();
        if ($stm->rowCount() > 1) $result = $stm->fetchAll();

        return $result;
    }
}
