<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description')->nullable();
            $table->string('book_number') ; //book_number je string zato sto moze da pocne sa 0;
            $table->unsignedBigInteger('author_id');
            $table->foreign('author_id')->references('id')->on('authors') ;
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users') ;
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
