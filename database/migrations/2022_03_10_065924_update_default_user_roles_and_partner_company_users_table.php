<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Silber\Bouncer\BouncerFacade as Bouncer;

class UpdateDefaultUserRolesAndPartnerCompanyUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // роли по умолчанию
        $rolePartnerAdmin = Bouncer::role()->firstOrCreate([
            'name' => 'partnerAdmin',
            'title' => 'Партнёр админ',
        ]);

        $rolePartnerEmployee = Bouncer::role()->firstOrCreate([
            'name' => 'partnerEmployee',
            'title' => 'Партнёр сотрудник',
        ]);

        $roleCustomerAdmin = Bouncer::role()->firstOrCreate([
            'name' => 'customerAdmin',
            'title' => 'Покупатель админ компании',
        ]);

        $roleCustomerEmployee = Bouncer::role()->firstOrCreate([
            'name' => 'customerEmployee',
            'title' => 'Покупатель сотрудник компании',
        ]);

        Schema::table('company_user', function (Blueprint $table) {
            $table->boolean('is_admin')
                ->comment('Это админ компании')
                ->default(0);
        });

        Schema::table('partner_user', function (Blueprint $table) {
            $table->boolean('is_admin')
                ->comment('Это админ партнёра')
                ->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('company_user', function (Blueprint $table) {
            $table->dropColumn(['is_admin']);
        });
        Schema::table('partner_user', function (Blueprint $table) {
            $table->dropColumn(['is_admin']);
        });
    }
}
