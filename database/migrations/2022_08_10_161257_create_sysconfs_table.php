<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysconfsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sysconfs', function (Blueprint $table) {
            $table->id();
	        $table->string('name');
	        $table->string('host')->nullable();
	        $table->string('port')->nullable();
	        $table->string('database')->nullable();
	        $table->string('username')->nullable();
	        $table->string('password')->nullable();
	        $table->string('sftp_host')->nullable();
	        $table->string('sftp_port')->nullable();
	        $table->string('sftp_username')->nullable();
	        $table->string('sftp_password')->nullable();
	        $table->boolean('fifco');
            $table->timestamps();
            $table->engine ='InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sysconfs');
    }
}
