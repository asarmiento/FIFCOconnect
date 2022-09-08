<?php

namespace App\Console\Commands\SendFilesFIFCO\Faca;

use App\Entities\Customers\Customer;
use App\Entities\Customers\CustomerEquipment;
use App\Entities\General\Sysconf;
use App\Models\Sysconf as localSysconf;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CustomerFormat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'faca:CustomerFormat';

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
	    $localSysconf=localSysconf::where('id',1)->first();

	    connectDBCustomer($localSysconf);
	    connectionDataBase();
	    env('DB_DATABASE_FIFCO',$localSysconf->database);
	    env('DB_USERNAME_FIFCO',$localSysconf->username);
	    env('DB_PASSWORD_FIFCO',$localSysconf->password);

	    env('SFTP_HOST',$localSysconf->sftp_host);
	    env('SFTP_USERNAME',$localSysconf->sftp_username);
	    env('SFTP_PASSWORD',$localSysconf->sftp_password);
	    //	Excel::download();
	    $fh=fopen(storage_path("app".DIRECTORY_SEPARATOR."FIFCO".DIRECTORY_SEPARATOR."customersFormat.txt"),'w') or die("Se produjo un error al crear el archivo");
	    $customers=Customer::all();
	    $sysconf=Sysconf::first();
		    $this->info("cliente :".json_encode($sysconf));
	    foreach ($customers AS $customer) {
				$neighborhood = $customer->neighborhood;
		    if ($neighborhood != null) {
			    $codeProvince=$neighborhood->code_province;
			    $nameProvince=$neighborhood->name_province;
			    $codeCanton=$neighborhood->code_canton;
			    $nameCanton=$neighborhood->name_canton;
			    $codeDistrict=$neighborhood->code_district;
			    $nameDistrict=$neighborhood->name_district;
		    }else{
			    $codeProvince="";
			    $nameProvince="";
			    $codeCanton="";
			    $nameCanton="";
			    $codeDistrict="";
			    $nameDistrict="";
		    }
		    $chanel=$customer->channel;

		    if($chanel!=null){
			    $chanelId = $chanel['id'];
			    $chanel = $chanel['name'];
		    }else{
			    $chanel="";
			    $chanelId="";
		    }
		    $zone=$customer->zone;
		    if($zone!=null) {
			    $zoneId=$zone['id'];
			    $zone=$zone['name'];
		    }else{
			    $zone = "";
			    $zoneId = "";
		    }
		    $texto="CR|$sysconf->code|$customer->id|$customer->code|$customer->company_name|$customer->address|$customer->fantasy_name|$customer->phone|||$codeProvince|$codeCanton|$codeDistrict|$chanelId|$zoneId||$customer->status|$customer->card|$customer->longitud|$customer->latitud|$nameProvince|$nameCanton|$nameDistrict|$chanel|$zone|\n";
		    fwrite($fh,$texto) or die("No se pudo escribir en el archivo");

	    }
	    ;
	    fclose($fh);

	    $local = Storage::disk('local')->path("FIFCO".DIRECTORY_SEPARATOR."customersFormat.txt");

	    Storage::disk('sftp')->put(DIRECTORY_SEPARATOR."clientes".Carbon::now()->format('dmY').".txt",fopen($local,'r+'));
	    //Storage::disk('sftp')->put(DIRECTORY_SEPARATOR."clientes02082022.txt",fopen($local,'r+'));


    }
}
