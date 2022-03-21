<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCompanyUsersAndPartnerUsersTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company_user', function (Blueprint $table) {
            // делаем поле phone не уникальным
            $table->dropUnique('company_user_phone_unique');
        });

        Schema::table('partner_user', function (Blueprint $table) {
            // делаем поле phone не уникальным
            $table->dropUnique('partner_user_phone_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company_user', function (Blueprint $table) {
            $table->string('phone')
                ->unique()
                ->comment('Телефон сотрудника')
                ->change();
        });

        Schema::table('partner_user', function (Blueprint $table) {
            $table->string('phone')
                ->unique()
                ->comment('Телефон сотрудника')
                ->change();
        });
    }
}
