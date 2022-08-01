<?php

namespace App\Http\Controllers\FIFCO;

use App\Http\Controllers\Controller;

use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SFTPController extends Controller
{

    public function index()
    {


          //    $prueba=  Storage::disk('sftp')->allFiles();

	    $local = Storage::disk('local')->path("FIFCO".DIRECTORY_SEPARATOR."salesFormat.txt");

	    $prueba=  Storage::disk('sftp')->put(DIRECTORY_SEPARATOR."sales".Carbon::now()->format('dmY').".txt",fopen($local,'r+'));


    }
}
