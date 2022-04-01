<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            $table->string('name')
                ->comment('Название категории');
            /*
             * type
             * 1 - department - верхный уровень
             * 2 - taxon - нижний уровень
             */
            $table->integer('type')
                ->comment('Тип - это верхний уровень или нижний уровень');

            $table->string('slug')
                ->unique()
                ->comment('Слаг - Ссылка');

            $table->integer('position')
                ->default(0)
                ->comment('Поле для сортировка');
            /*
             * active
             * 0 - Не активная
             * 1 - Активная
             */
            $table->boolean('active')
                ->default(0)
                ->comment('Категория активная если значения 1 не активная 0');

            $table->foreignIdFor(\App\Models\Category::class, 'parent_id')
                ->nullable()
                ->comment('Идентификатор родительского каталога');

            $table->foreignIdFor(\App\Models\Partner::class)
                ->nullable()
                ->comment('Идентификатор партнера, если партнер создал категорию');

            $table->string('icon_url')
                ->nullable()
                ->comment('Ссылка на иконка');

            $table->string('alt_icon')
                ->nullable()
                ->comment('Описание иконка');

            $table->string('canonical_url')
                ->nullable()
                ->comment('Канонический URL');

            $table->integer('depth')
                ->nullable()
                ->comment('Уровень категории');

            $table->jsonb('requirements')
                ->nullable()
                ->comment('требования категории');

            $table->jsonb('attributes')
                ->nullable()
                ->comment('Атрибут категории');
            /*
             * is_alcohol
             * 0 - Не Алкогольная
             * 1 - Алкогольная
             */
            $table->boolean('is_alcohol')
                ->default(0)
                ->comment('Является ли категория алкогольная? 1 - да; 0 - нет');

            $table->timestamps();

            $table->foreign('parent_id')
                ->references('id')
                ->on('categories');

            $table->foreign('partner_id')
                ->references('id')
                ->on('partners');
        });

    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
