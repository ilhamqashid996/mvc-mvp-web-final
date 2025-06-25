<?php 

defined('ROOTPATH') OR exit('Access Denied!');

if ($_SERVER['SERVER_NAME'] == 'localhost')
{
    /** database config **/
    define('DBNAME', 'db_archive3');
    define('DBHOST', 'localhost');
    define('DBUSER', 'root');
    define('DBPASS', '');

    define('ROOT', 'http://localhost:70/projects/mvp-web-final/public');
}

define('APP_NAME', "Web App");
define('APP_DESC', "This is My Web Application");

define('DEBUG', true);
