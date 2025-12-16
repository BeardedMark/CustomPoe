<?php

namespace App\Services;

class Command
{
    public $name;
    public $value;
    public $comment;

    public function __construct($name, $value = '', $comment = '')
    {
        $this->name = $name;
        $this->value = $value;
        $this->comment = $comment;
    }
}
