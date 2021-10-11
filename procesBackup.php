<?php

//Datos de la base de datos
$mysqlDatabaseName = DATANAME;
$mysqlUserName = DATAUSER;
$mysqlPassword = DATAPASS;
$mysqlHostName = 'localhost';
$mysqlExportPath = 'backup/backup_'.date('D').'.sql';

// Backup con mysqldump
$command='mysqldump --opt -h' .$mysqlHostName .' -u' .$mysqlUserName .' -p' .$mysqlPassword .' ' .$mysqlDatabaseName .' > ' .$mysqlExportPath;
exec($command,$output,$worked);

switch($worked){
    case 0:
    $msg= 'La base de datos ' .$mysqlDatabaseName .' se ha almacenado correctamente en la siguiente ruta '.getcwd().'/' .$mysqlExportPath .'';
    insert('', $msg);
    break;
    case 1:
    $msg='Se ha producido un error al exportar ' .$mysqlDatabaseName .' a '.getcwd().'/' .$mysqlExportPath .'';
    insert('', $msg);
    break;
    case 2:
    $msg='Se ha producido un error de exportación, compruebe la información de acceso a su bd';
    insert('', $msg);
    break;
}

function insert($url='',$text)
    {
        date_default_timezone_set('America/Bogota');
        if($url!='')
        {
            $logFile = fopen("backup/log.txt", 'a') or die("Error creando archivo");
        }
        else
        {
            $logFile = fopen("backup/log.txt", 'a') or die("Error creando archivo");
        }      
        $ip = getRealIP();
        fwrite($logFile, "\n" . date("d/m/Y H:i:s").' '.$ip.' '.$text) or die("Error escribiendo en el archivo");
        fclose($logFile);
    }
function getRealIP()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
        return $_SERVER['HTTP_CLIENT_IP'];

        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        return $_SERVER['HTTP_X_FORWARDED_FOR'];

        return $_SERVER['REMOTE_ADDR'];
    }
