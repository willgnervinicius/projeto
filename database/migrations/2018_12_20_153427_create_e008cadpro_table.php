<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateE008cadproTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e008cadpro', function (Blueprint $table) {
          $table->integer('CodEmp')->nullable();
          $table->integer('CodPro');
          $table->string('DesPro');
          $table->string('NomPro');
          $table->string('MarPro');
          $table->string('PriCpl');
          $table->string('SegCpl');
          $table->string('VarPro');
          $table->string('DesEmb');
          $table->string('UniMed');
          $table->string('TipPro');
          $table->string('TipMer');
          $table->string('CtlEst');
          $table->integer('CodDep');
          $table->integer('CodGru');
          $table->integer('CodSub');
          $table->string('DesNfe');
          $table->char('SitPro',1);
          $table->integer('CodUsu')->nullable();
          $table->Date('DatCad')->nullable();
          $table->time('HorCad')->nullable();
          $table->integer('UsuAtu')->nullable();
          $table->Date('DatAtu')->nullable();
          $table->time('HorAtu')->nullable();

         $table->primary(['CodEmp', 'CodPro']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('e008cadpro');
    }
}
