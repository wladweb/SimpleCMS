<?php

namespace Wladweb\SimpleCMS\Assets;

use Wladweb\SimpleCMS\Application as App;
use RedBeanPHP\R;
use RedBeanPHP\RedException;

/**
 * Description of Connection
 *
 * @author wladweb
 */
class Connection
{

    public static function connect()
    {
        $setup_file = App::$app_dir . DIRECTORY_SEPARATOR . 'setup.ini';
        if (!\file_exists($setup_file)) {
            include App::$app_dir . DIRECTORY_SEPARATOR . 'src/View/atemplate/config_not_found.php';
            exit;
        }

        $db_data = parse_ini_file($setup_file);

        if ($db_data === false) {
            echo "setup.ini file is invalid";
            exit;
        }

        $dsn = "mysql:host={$db_data['host']};dbname={$db_data['dbname']}";
        $user = $db_data['user'];
        $password = $db_data['pass'];

        R::setup($dsn, $user, $password);
        if (false === R::testConnection()){
            echo 'Unable connect to database';exit;
        }
    }

}
