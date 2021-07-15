<?php

namespace Helpers;

use mysqli;

class DatabaseConfig {

    CONST HOSTNAME = 'db';
    CONST USERNAME = 'vitaplus';
    CONST PASSWORD = '1ajd2OnnauhGfvlURTg2';
    CONST DATABASE = 'myDb';

    public static function connect()
    {
        $con = new mysqli(self::HOSTNAME , self::USERNAME , self::PASSWORD , self::DATABASE) or die('Error: '.mysqli_connect_error());
        /* comprobar la conexión */
        if (mysqli_connect_errno()) {
            return false;
        }
        return $con;
    }
    public static function disconnect($con)
    {
        mysqli_close($con);
    }
}