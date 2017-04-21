<?php

namespace Test;

abstract class Engine
{
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
}
