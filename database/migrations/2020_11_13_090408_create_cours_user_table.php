<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
class CreateCoursUserTable extends Migration
{
    public function up()
    {
        Schema::create('cours_user', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('rating');
            $table->unsignedInteger('user_id')->index();
            $table->unsignedInteger('cours_id')->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('cours_id')->references('id')->on('cours')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::drop('cours_user');
    }
}
