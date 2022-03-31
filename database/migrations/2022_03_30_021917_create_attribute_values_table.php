<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributeValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_values', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Attribute::class)
                ->comment('Связь с атрибутами таблицы');

            $table->foreignIdFor(\App\Models\Partner::class)
                ->nullable()
                ->comment('Связь с партнёр таблицы');

            $table->string('value')
                ->comment('Значения атрибута для тип список');

            $table->boolean('is_global')
                ->default(0)
                ->comment('Глобалный атрибут значения');

            $table->integer('position')
                ->default(0)
                ->comment('Поле для сортировки');

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
        Schema::dropIfExists('attribute_values');
    }
}
