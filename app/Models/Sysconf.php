<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sysconf extends Model
{
			protected $table = 'sysconfs';
			protected $fillable = ['name', 'host', 'port', 'database', 'username', 'password', 'sftp_host', 'sftp_port', 'sftp_username', 'sftp_password', 'fifco'];


    use HasFactory;
}
