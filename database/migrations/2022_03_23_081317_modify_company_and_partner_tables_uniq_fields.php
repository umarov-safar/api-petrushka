<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCompanyAndPartnerTablesUniqFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            // делаем поле phone не уникальным
            $table->dropUnique('companies_phone_unique');
        });

        Schema::table('partners', function (Blueprint $table) {
            // делаем поле phone не уникальным
            $table->dropUnique('partners_phone_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('phone')
                ->unique()
                ->comment('Телефон админа компании')
                ->change();
        });

        Schema::table('partners', function (Blueprint $table) {
            $table->string('phone')
                ->unique()
                ->comment('Телефон админа партнера')
                ->change();
        });
    }
}
