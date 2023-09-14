<?php
require_once 'Hellpers/Request.php';

/**
 * Class BaseController
 */
class BaseController
{
    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return Request::i();
    }
}