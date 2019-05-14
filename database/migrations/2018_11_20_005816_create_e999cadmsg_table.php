<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateE999cadmsgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e999cadmsg', function (Blueprint $table) {
          $table->increments('CodMsg');
          $table->integer('GruEmp')->nullable();;
          $table->integer('UsuDes');
          $table->integer('UsuRem');
          $table->char('CabMsg',30);
          $table->string('DesMsg');
          $table->Date('DatCad');
          $table->Date('DatExc')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('e999cadmsg');
    }
}
