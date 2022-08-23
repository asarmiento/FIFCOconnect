<?php

namespace App\Console\Commands\SendFilesFIFCO\Virginia;

use App\Entities\General\Sysconf;
use App\Entities\Invoices\Invoice;
use App\Models\Sysconf as localSysconf;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SaleFormat extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature='Virginia:saleFormat';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description='Command description';

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
		$localSysconf=localSysconf::find(3);

		connectDBCustomer($localSysconf);
			connectionDataBase();
			env('DB_DATABASE_FIFCO',$localSysconf->database) ;
			env('DB_USERNAME_FIFCO',$localSysconf->username) ;
			env('DB_PASSWORD_FIFCO',$localSysconf->password) ;

			env('SFTP_HOST',$localSysconf->sftp_host) ;
			env('SFTP_USERNAME',$localSysconf->sftp_username) ;
			env('SFTP_PASSWORD',$localSysconf->sftp_password) ;

			set_time_limit(0);
			ini_set('memory_limit','94G');
			$fh=fopen(storage_path("app".DIRECTORY_SEPARATOR."FIFCO".DIRECTORY_SEPARATOR."Virginia".DIRECTORY_SEPARATOR."salesFormat.txt"),'w') or die("Se produjo un error al crear el archivo");
		$sysconf=Sysconf::first();
		$invoices=Invoice::where('sysconf_id',$sysconf->id)->where('invoice_type_id',2)->where('ind_estado','aceptado')->where('date','>=',Carbon::now()->subMonth(1)->firstOfMonth()->toDateString())->get();
			Log::info("ventas ".json_encode($invoices));
				$this->info("cliente :".json_encode($sysconf));
			foreach ($invoices AS $invoice) {
				$customer=$invoice->sale->customer;
				Log::info("ventas ".json_encode($customer));
				$type="";

				if ($invoice->type == '01' || $invoice->type == '04') {
					$type='FA';
				}
				$neighborhood=$customer->neighborhood;
				if ($neighborhood != null) {
					$codeProvince=$neighborhood->code_province;
					$nameProvince=$neighborhood->name_province;
					$codeCanton=$neighborhood->code_canton;
					$nameCanton=$neighborhood->name_canton;
					$codeDistrict=$neighborhood->code_district;
					$nameDistrict=$neighborhood->name_district;
				} else {
					$codeProvince="";
					$nameProvince="";
					$codeCanton="";
					$nameCanton="";
					$codeDistrict="";
					$nameDistrict="";
				}
				$chanel=$customer->channel;
				if ($chanel != null) {
					$chanel=$chanel->id;
				} else {
					$chanel="";
				}
				$zone=$customer->zone;
				if ($zone != null) {
					$zone=$zone->id;
				} else {
					$zone="";
				}
				$codeCustomer=trim($customer->code);
				$idCustomer=$customer->id;

				foreach ($invoice->productByInvoice AS $productBy) {
					$date=Carbon::parse($invoice->date)->format('d/m/Y');
					$datePresale=Carbon::parse($invoice->date_presale)->format('d/m/Y');
					$product=$productBy->product;
					$barcode=trim($product['barcode']);
					$code=trim($product['code']);
					$description=trim($product['description']);
					$units_per_box=trim($product['units_per_box']);

					$texto="CR|$sysconf->code|$idCustomer|$codeCustomer|$customer->company_name|$customer->address|$customer->phone|||$barcode|$code|$description|$productBy->delivered|$productBy->subtotal|$productBy->m_total|$units_per_box|$datePresale|$date|$codeProvince|$codeCanton|$codeDistrict|$chanel|$zone||$invoice->numeration|$type|AV\n";
					fwrite($fh,$texto) or die("No se pudo escribir en el archivo");
				}
			}

			fclose($fh);

			$local=Storage::disk('local')->path("FIFCO".DIRECTORY_SEPARATOR."Virginia".DIRECTORY_SEPARATOR."salesFormat.txt");
		if(Carbon::now()->toDateString() =='2022-08-21'){
	Storage::disk('sftp')->put(DIRECTORY_SEPARATOR."ventas21082022.txt",fopen($local,'r+'));
}else{
	Storage::disk('sftp')->put(DIRECTORY_SEPARATOR."ventas".Carbon::now()->format('dmY').".txt",fopen($local,'r+'));
}

			//


	}
}