<?php

require_once dirname(__DIR__, 2) . "/lib/Repository/AbstractRepository.php";
require_once dirname(__DIR__) . "/Model/Category.php";
require_once dirname(__DIR__) . "/Model/Article.php";

class CategoryRepository extends AbstractRepository
{
    
     /**
     * @param User $user prend en paramètre un onject User
     * @return arrayCollection Category 
     */
    public function findByArticle(Article $article): mixed
    {
        $query = "SELECT DISTINCT id, name FROM category 
                JOIN article_category as ac
                WHERE ac.article_id = :article_id ;";
        $params = [":article_id" => $article->getId()];
        return $this->executeQuery($query, "Category", $params);
    }
}
