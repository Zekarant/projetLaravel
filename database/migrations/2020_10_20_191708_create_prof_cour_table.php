<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateProfCourTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prof_cour', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('prof_id');
            $table->unsignedInteger('cour_id');
            $table->foreign('prof_id')->references('id')->on('profs')->onDelete('cascade');
            $table->foreign('cour_id')->references('id')->on('cours')->onDelete('cascade');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prof_cour');
    }
}
