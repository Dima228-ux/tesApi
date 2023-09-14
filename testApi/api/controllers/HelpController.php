<?php

/**
 * Class  HelpController
 */
class HelpController
{
    /**
     * @return array[]
     */
    public function indexAction()
    {
        echo json_encode(['message' => 'You are welcome to API']);
    }
}