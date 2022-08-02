<?php

namespace App\Console\Commands\SendFilesFIFCO\Faca;

use App\Entities\General\Sysconf;
use App\Entities\Products\Inventory;
use App\Entities\Products\Product;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ProductsFormat extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature='friendly:productFormat';

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
		$fh=fopen(storage_path("app".DIRECTORY_SEPARATOR."FIFCO".DIRECTORY_SEPARATOR."productsFormat.txt"),'w') or die("Se produjo un error al crear el archivo");
		$products=Product::where('status','Activo')->get();
		$sysconf=Sysconf::first();
		foreach ($products AS $product) {
			if ($product->inventory) {
				$inventory=$product->inventory->amount;
				$cost=round($product->inventory->amount * $product->cost);
			} else {
				Inventory::create([
					'amount'          =>0,
					'product_id'      =>$product->id,
					'branch_office_id'=>$sysconf->branchOffice->id
				]);

				$inventory=0;
				$cost=0;
			}

			$date=Carbon::now()->format('d/m/Y');
			$texto="CR|$sysconf->code|$product->barcode|$product->code|$product->description|1|$inventory|$cost|$date\n";
			fwrite($fh,$texto) or die("No se pudo escribir en el archivo");

		}

		fclose($fh);

		$local=Storage::disk('local')->path("FIFCO".DIRECTORY_SEPARATOR."productsFormat.txt");

		//  Storage::disk('sftp')->put(DIRECTORY_SEPARATOR."inventario".Carbon::now()->format('dmY').".txt",fopen($local,'r+'));
		Storage::disk('sftp')->put(DIRECTORY_SEPARATOR."inventario31072022.txt",fopen($local,'r+'));

	}
}
