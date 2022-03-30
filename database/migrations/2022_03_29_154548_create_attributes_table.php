<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')
                ->comment('Тип это строка, число, список и.тд');

            $table->string('slug')->unique();
            $table->boolean('is_global')->default(0);
            $table->integer('position')->default(0);
            $table->unsignedBigInteger('partner_id')->nullable();
            $table->timestamps();

            $table->foreign('partner_id')
                ->references('id')
                ->on('partners')
                ->onDelete('SET NULL');

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
        Schema::dropIfExists('attributes');
    }
}
