<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateE999cadusuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e999cadusu', function (Blueprint $table) {
          $table->increments('CodUsu');
          $table->string('NomUsu');
          $table->string('CgcCpf')->unique();
          $table->string('SenUsu');
          $table->string('IntNet')->unique();
          $table->string('SitUsu');
          $table->date('DatCad');
          $table->date('UsuCad')->nullable();
          $table->string('FotUsu')->default('default.jpg');
          $table->rememberToken();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('e999cadusu');
    }
}
