<?php

namespace Andrey;

use FaaPz\PDO\Database;

class Connection
{
    public function getPdo()
    {
        $dsn = "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB']};charset=utf8";
        $usr = "{$_ENV['DB_USER']}";
        $pwd = "{$_ENV['DB_PASS']}";

        return new Database($dsn, $usr, $pwd);
    }
}
