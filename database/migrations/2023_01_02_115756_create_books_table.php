<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   //جدول الكتب وهاد اهم جدول
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('publisher_id')->nullable();
            $table->string('title');
            $table->string('isbn')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('publish_year')->nullable();
            $table->unsignedInteger('number_of_pages');
            $table->unsignedInteger('number_of_copies');
            //السعر في الوقت الحالي للكتاب
            $table->decimal('price', 8 , 2);
            $table->string('cover_image');
            $table->timestamps();

            //مفتاح الربط مع الاصناف
            $table->foreign('category_id')->references('id')->on('categories')
                ->onDelete('set null');
            //مفتاح الربط مع الناشرين
            $table->foreign('publisher_id')->references('id')->on('publishers')
                ->onDelete('set null');
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
};
