<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')
                ->comment('Название продукта');

            $table->integer('sku')
                ->comment('Артикул');

            $table->text('description')
                ->comment('Краткое описание');

            $table->text('description_original')
                ->comment('Длинное описание');

            $table->string('slug')
                ->comment('Ссылка - слаг');

            $table->string('human_volume')
                ->nullable()
                ->comment('Кг, Шт, Метр и тд');

            $table->string('canonical_permalink')
                ->nullable()
                ->comment('URL');

            $table->boolean('is_alcohol')
                ->default(0)
                ->comment('продукт алкогольный? 1 - да, 0 - нет');

            $table->foreignIdFor(\App\Models\Category::class)
                ->comment('Идентификатор категории');

            $table->foreignIdFor(\App\Models\Brand::class)
                ->nullable()
                ->comment('Идентификатор бренда');

            $table->foreignIdFor(\App\Models\Manufacturer::class)
                ->nullable()
                ->comment('Идентификатор производителя');

            $table->foreignIdFor(\App\Models\ManufacturingCountry::class)
                ->nullable()
                ->comment('Идентификатор страны производителя');

            $table->foreignIdFor(\App\Models\Partner::class)
                ->nullable()
                ->comment('Идентификатор партнера (partners)');


            $table->jsonb('attributes')
                ->nullable()
                ->comment('Атрибуты товара');

            $table->foreign('category_id')
                ->references('id')
                ->on('categories');

            $table->foreign('brand_id')
                ->references('id')
                ->on('brands');

            $table->foreign('manufacturer_id')
                ->references('id')
                ->on('manufacturers');

            $table->foreign('manufacturing_country_id')
                ->references('id')
                ->on('manufacturing_countries');

            $table->foreign('partner_id')
                ->references('id')
                ->on('partners');

            $table->softDeletes();

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
        Schema::dropIfExists('products');
    }
}
