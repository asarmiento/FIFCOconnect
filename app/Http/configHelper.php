<?php


use App\Models\Sysconf;
use Illuminate\Support\Facades\Session;

function connectionDataBase()
{
    config([
        'database.connections.mysql_fifco.host'=>Session::get('DB_HOST_FIFCO'),
        'database.connections.mysql_fifco.port'=>Session::get('DB_PORT_FIFCO'),
        'database.connections.mysql_fifco.database'=>Session::get('DB_DATABASE_FIFCO'),
        'database.connections.mysql_fifco.username'=>Session::get('DB_USERNAME_FIFCO'),
        'database.connections.mysql_fifco.password'=>Session::get('DB_PASSWORD_FIFCO'),
        'filesystems.disks.sftp.host'=>Session::get('SFTP_HOST'),
        'filesystems.disks.sftp.username'=>Session::get('SFTP_USERNAME'),
        'filesystems.disks.sftp.password'=>Session::get('SFTP_PASSWORD'),
    ]);
}

function connectDBCustomer($sysconf)
{
/*	*/


	Session::put('sysconf',$sysconf);
	Session::put('DB_HOST_FIFCO',$sysconf->host);
	Session::put('DB_PORT_FIFCO',$sysconf->port);
	Session::put('DB_DATABASE_FIFCO',$sysconf->database);
	Session::put('DB_USERNAME_FIFCO',$sysconf->username);
	Session::put('DB_PASSWORD_FIFCO',$sysconf->password);
	Session::put('SFTP_HOST',$sysconf->sftp_host);
	Session::put('SFTP_USERNAME',$sysconf->sftp_username);
	Session::put('SFTP_PASSWORD',$sysconf->sftp_password);



}
