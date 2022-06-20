<?php

require_once dirname(__DIR__, 2) . "/lib/Controller/AbstractController.php";

class ContactController extends AbstractController
{

    /**
     * @Route contact
     */
    public function index()
    {
        return $this->renderView(
            "/template/contact/contact_base.phtml",
            [
                "name_page" => "contactPage",
                "message" => "hello world"
            ]
        );
    }
}
