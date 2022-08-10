<?php

namespace App\Console\Commands\SendFilesFIFCO\Faca;

use App\Entities\General\Sysconf;
use App\Entities\Customers\CustomerEquipment;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CameraFormat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'friendly:cameraFormat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
	    //	Excel::download();
	    $fh=fopen(storage_path("app".DIRECTORY_SEPARATOR."FIFCO".DIRECTORY_SEPARATOR."camerasFormat.txt"),'w') or die("Se produjo un error al crear el archivo");
	    $customers=CustomerEquipment::all();
	    $sysconf=Sysconf::first();
	    foreach ($customers AS $customer) {
		    $code = $customer->customer->code;
		    $texto="CR|$sysconf->code|$customer->placa|$code|$customer->placa\n";
		    fwrite($fh,$texto) or die("No se pudo escribir en el archivo");

	    }

	    fclose($fh);
	    $local = Storage::disk('local')->path("FIFCO".DIRECTORY_SEPARATOR."camerasFormat.txt");

	    Storage::disk('sftp')->put(DIRECTORY_SEPARATOR."camaras".Carbon::now()->format('dmY').".txt",fopen($local,'r+'));
	    //Storage::disk('sftp')->put(DIRECTORY_SEPARATOR."camaras02082022.txt",fopen($local,'r+'));

    }
}
