<?php

require_once dirname(__DIR__, 2) . "/lib/Repository/AbstractRepository.php";
require_once dirname(__DIR__) . "/Model/Article.php";

class ArticleRepository extends AbstractRepository
{

    /**
     * @param string $id article 
     * @return Article|null
     */
    public function find(string $id)
    {
        $query = "SELECT * FROM article WHERE id = :id";
        $params = [":id" => $id];

        return  $this->executeQuery($query, "article", $params);
    }

    /**
     * @return array collection Article
     */
    public function findAll()
    {
        $query = "SELECT * FROM article;";
        return $this->executeQuery($query, "Article");
    }
}
