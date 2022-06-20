<?php

require_once dirname(__DIR__, 2) . "/lib/Repository/AbstractRepository.php";
require_once dirname(__DIR__) . "/Model/Article.php";

class ArticleRepository extends AbstractRepository
{

    public function findAll()
    {
        $query = "SELECT * FROM article;";

        $result = $this->executeQuery($query, "Article");
        var_dump($result);
    }
}
