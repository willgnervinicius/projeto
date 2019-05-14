<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateE008cadgruTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e008cadgru', function (Blueprint $table) {
          $table->integer('CodEmp')->nullable();
          $table->integer('CodDep');
          $table->increments('CodGru');
          $table->string('NomGru');
          $table->char('SitGru',1);
          $table->integer('CodUsu')->nullable();
          $table->Date('DatCad')->nullable();
          $table->time('HorCad')->nullable();
          $table->integer('UsuAtu')->nullable();
          $table->Date('DatAtu')->nullable();
          $table->time('HorAtu')->nullable();

          $table->primary(['CodEmp','CodDep','CodGru']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('e008cadgru');
    }
}
