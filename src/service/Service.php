<?php

class Service
{
    /**
     * @return bool  
     */
    public static function  checkIfUserIsConnected()
    {
        $user_is_connected = false;
        $userRepository =  new UserRepository();
        if (
            isset(
                $_SESSION["user_is_connected"],
                $_SESSION["user_id"]
            )
            && $_SESSION["user_is_connected"]
            && $userRepository->find($_SESSION["user_id"])
        ) {
            $user_is_connected = true;
        }
        return $user_is_connected;
    }

    /**
     * @param array $_FILE["name_file"]
     * @return  string|null
     */
    public static function moveFile(array $file): ?string
    {
        $filePath = null;
        $folder = dirname(__DIR__, 2) . "/public/img/upload/";
        if (!file_exists($folder)) {
            mkdir($folder, 0777);
        }
        $filename = self::renameFile($file["name"]);
        if (move_uploaded_file($file["tmp_name"], $folder . $filename)) {
            $filePath = "/img/upload/" . $filename;
        }
        return $filePath;
    }

    /**
     * @param array 
     * @return array|null
     */
    public static function  checkCategoriesExist(array $categoriesSearched): ?array
    {
        $categories = null;
        $categoryRepository = new CategoryRepository();
        // cherche si une category existe avec l'Id passé 
        foreach ($categoriesSearched as $key => $categorySearch) {
            // si oui on ajoute un element à notre array
            if ($category = $categoryRepository->find(intval($categorySearch))) $categories[] =  $category;
        }
        return $categories;
    }

    /**
     * @param string $filename
     * @return string
     */
    private static function renameFile(string $filename): string
    {
        $array = explode(".", $filename);
        return (new DateTime("now"))->format("Ymdhis") . "." . end($array);
    }
}
