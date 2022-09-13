<?php

namespace App\Console\Commands\SendFilesFIFCO\Jagris;

use App\Entities\General\Sysconf;
use App\Models\Sysconf AS localSysconf;
use App\Entities\Customers\CustomerEquipment;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class CameraFormat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jagris:cameraFormat';

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

	    $localSysconf=localSysconf::find(2);

	    connectDBCustomer($localSysconf);
	    connectionDataBase();
		    env('DB_DATABASE_FIFCO',$localSysconf->database) ;
		    env('DB_USERNAME_FIFCO',$localSysconf->username) ;
		    env('DB_PASSWORD_FIFCO',$localSysconf->password) ;

		    env('SFTP_HOST',$localSysconf->sftp_host) ;
		    env('SFTP_USERNAME',$localSysconf->sftp_username) ;
		    env('SFTP_PASSWORD',$localSysconf->sftp_password) ;
		    $sysconf = DB::connection('mysql_fifco')->table('sysconfs')->first();
		    $this->info("cliente :".json_encode($sysconf));
		    $fh=fopen(storage_path("app".DIRECTORY_SEPARATOR."FIFCO".DIRECTORY_SEPARATOR."Jagris".DIRECTORY_SEPARATOR."camerasFormat.txt"),'w') or die("Se produjo un error al crear el archivo");
		    $customers=CustomerEquipment::whereHas('customer',function ($c) use($sysconf){
		    	$c->where('sysconf_id',$sysconf->id);
		    })->get();
		    foreach ($customers AS $customer) {
			    $code=$customer->customer->code;
			    $placa=$customer->placa;
			    $texto="CR|$sysconf->code|$customer->placa|$code|$placa\r\n";
			    fwrite($fh,$texto) or die("No se pudo escribir en el archivo");

		    }

		    fclose($fh);
		    $local=Storage::disk('local')->path("FIFCO".DIRECTORY_SEPARATOR."Jagris".DIRECTORY_SEPARATOR."camerasFormat.txt");

		    Storage::disk('sftp')->put(DIRECTORY_SEPARATOR."camaras".Carbon::now()->format('dmY').".txt",fopen($local,'r+'));
		    //Storage::disk('sftp')->put(DIRECTORY_SEPARATOR."camaras02082022.txt",fopen($local,'r+'));


    }
}
