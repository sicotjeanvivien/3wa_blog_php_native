<?php

require_once dirname(__DIR__, 2) . "/lib/Repository/AbstractRepository.php";
require_once dirname(__DIR__) . "/Model/User.php";

class UserRepository extends AbstractRepository
{
    /**
     * @param User $user prend en paramètre un onject User
     * @return mixed une valeur 
     */
    public function insert(User $user): mixed
    {
        $query = "INSERT INTO user(lastname, firstname, username, password) 
                  VALUES(:lastname, :firstname, :username, :password);";
        $params = [
            ":lastname" => $user->getLastname(),
            ":firstname" => $user->getFirstname(),
            ":username" => $user->getUsername(),
            ":password" => $user->getPassword()
        ];
        return $this->executeQuery($query, "user", $params);
    }
}
