<?php
namespace App\Framework;

abstract class AbstractModel {

    protected Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }
}