<?php

namespace App\Http\Controllers\FIFCO;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SFTPController extends Controller
{

    public function index()
    {
      $prueba=  Storage::disk('sftp')->move(storage_path("/app/FIFCO/salesFormat.txt"),"camaras/salesFormat.txt");
      dd($prueba);
    }
}
