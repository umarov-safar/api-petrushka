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

            $table->string('name')
                ->comment('Названия атрибута');
            /**
             * type
             * 1 - text,
             * 2 - number
             * 3 - select
             */
            $table->integer('type')
                ->comment('Тип атрибута: 1 - text; 2 - number; 3 - select');

            $table->string('slug')
                ->comment('Слаг - ссылка');
            /**
             * is_global
             * 0 - Не глобаный
             * 1 - Глобалный
             */
            $table->boolean('is_global')
                ->default(0)
                ->comment('Является ли атрибут глобальным для всех партнеров');

            $table->integer('position')
                ->default(0)
                ->comment('Поле для сортировки');

            $table->unsignedBigInteger('partner_id')
                ->nullable()
                ->comment('Идентификатор партнера, если партнер создал категорию');

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
