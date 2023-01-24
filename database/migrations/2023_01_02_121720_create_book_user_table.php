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
    {   //جدول الربط بين الكتاب والمستخدم
        //يتسخدم لحفظ الكتب بعد عمليات الشراء
        Schema::create('book_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('book_id');
            $table->unsignedInteger('number_of_copies')->default(1);
            $table->boolean('bought')->default(false);
            //السعر في الوقت الذي اشترى به المستخدم الكتاب
            $table->decimal('price' , 8, 2);
            $table->timestamps();

            //مفتاح الربط مع المستخدمين
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');
            //مفتاح الربط مع الكتب
            $table->foreign('book_id')->references('id')->on('books')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_user');
    }
};
