<?php

    require_once 'vendor/autoload.php';
    require_once 'libs/sqlobjects/generated-conf/config.php';
    require_once 'libs/Autoload.php';
    new Autoload('libs/base/');

    if(!isset($argv[1])) $argv[1] = "";

    switch($argv[1]){
        case "":
            print("No argument was passed. Please use `php manage.php help` to seek help ... \n");
            break;
        case "sql_build":
            if(!isset($argv[2])){
                echo shell_exec("vendor/bin/propel sql:build");
            }

            if(isset($argv[2]) && $argv[2] == "--overwrite"){
                echo shell_exec("vendor/bin/propel sql:build --overwrite");
            }
            break;
        case "sql_insert":
            echo shell_exec("vendor/bin/propel sql:insert");
            break;
        case "model_build":
            echo shell_exec("vendor/bin/propel model:build");
            break;
        case "convert_config":
            echo shell_exec("vendor/bin/propel config:convert");
            break;
        case "createsuperuser":
            echo "Username: ";
            $username = DUtil::read_stdin();
            echo "Email: ";
            $email = DUtil::read_stdin();
            echo "Password: ";
            $password = DUtil::read_stdin();
            Authentication::create_superuser($username, $email, $password);
            break;
        case "help":
            echo "\n*********************************\n\n";
            echo "The commands to pass are below: \n";
            echo "\n\tmodel_build\n\tsql_build [--overwrite]\n\thelp\n\tconvert_config\n\tsql_insert\ncreatesuperuser\n";
            echo "\n*********************************\n\n";
            break;
        default:
            print("Argument passed is incorrect. Please use `php manage.php help` to seek help ... \n");
            break;
    }

?>
