<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Silber\Bouncer\BouncerFacade as Bouncer;
//use Bouncer;
use App\Models\User;

class UpdateDefaultUserRolesAbilities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // очищаем все таблицы и массива ниже
        $tables = ['users', 'roles', 'abilities', 'assigned_roles', 'permissions'];
        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }

        // superAdmin - пользователь с максимальными правами
        $superAdmin = new User();
        $superAdmin->name = 'SuperAdmin';
        $superAdmin->phone = '79999999999';
        $superAdmin->code = '986986';
        $superAdmin->save();

        // Роли
        $roleSuperAdmin = Bouncer::role()->firstOrCreate([
            'name' => 'superadmin',
            'title' => 'Супер администратор',
        ]);

        $roleAdmin = Bouncer::role()->firstOrCreate([
            'name' => 'admin',
            'title' => 'Администратор',
        ]);

        $roleCustomer = Bouncer::role()->firstOrCreate([
            'name' => 'customer',
            'title' => 'Покупатель',
        ]);

        $rolePartner = Bouncer::role()->firstOrCreate([
            'name' => 'partner',
            'title' => 'Партнёр',
        ]);

        // Возможности
        $abilityCreate = Bouncer::ability()->firstOrCreate([
            'name' => 'create',
            'title' => 'Создание',
        ]);
        $abilityEdit = Bouncer::ability()->firstOrCreate([
            'name' => 'edit',
            'title' => 'Изменение',
        ]);
        $abilityView = Bouncer::ability()->firstOrCreate([
            'name' => 'view',
            'title' => 'Просмотр',
        ]);
        $abilityList = Bouncer::ability()->firstOrCreate([
            'name' => 'list',
            'title' => 'Список',
        ]);
        $abilityDelete = Bouncer::ability()->firstOrCreate([
            'name' => 'delete',
            'title' => 'Удаление',
        ]);

        Bouncer::allow('superadmin')->everything(); // супер админу можно всё
        //Bouncer::assign('superadmin')->to($superAdmin);
        $superAdmin->assign('superadmin');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
