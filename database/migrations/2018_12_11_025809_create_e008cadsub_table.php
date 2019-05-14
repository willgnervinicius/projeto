<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateE008cadsubTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e008cadsub', function (Blueprint $table) {
          $table->integer('CodEmp')->nullable();
          $table->integer('CodGru');
          $table->increments('CodSub');
          $table->string('NomSub');
          $table->char('SitSub',1);
          $table->integer('CodUsu')->nullable();
          $table->Date('DatCad')->nullable();
          $table->time('HorCad')->nullable();
          $table->integer('UsuAtu')->nullable();
          $table->Date('DatAtu')->nullable();
          $table->time('HorAtu')->nullable();

          $table->primary(['CodEmp','CodGru','CodSub']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('e008cadsub');
    }
}
