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
        $result = null;
        // Connection BDD en PDO
        $conn = $this->connect();
        $stm = $conn->prepare($query);
        foreach ($params as $key => $param) $stm->bindValue($key, $param);
        if ($stm->execute()) {
            // récupérer les lignes de la BDD sous forme d'object
            strlen($class) && $stm->setFetchMode(PDO::FETCH_CLASS, $class);
            if ($stm->rowCount() === 1) $result = $stm->fetch();
            if ($stm->rowCount() > 1) $result = $stm->fetchAll();
        }
        
        $conn = null;
        return $result;
    }
}
