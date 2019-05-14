<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateE001cadempTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e001cademp', function (Blueprint $table) {
        $table->increments('CodEmp');
        $table->string('NomFan');
        $table->string('CgcMat')->Unique();
        $table->integer('GruEmp')->nullable();
        $table->char('SitEmp',1);
        $table->integer('CodUsu')->nullable();
        $table->Date('DatCad')->nullable();
        $table->time('HorCad')->nullable();
        $table->integer('UsuAtu')->nullable();
        $table->Date('DatAtu')->nullable();
        $table->time('HorAtu')->nullable();

        $table->primary('CodEmp');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('e001cademp');
    }
}
