<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnerUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partner_user', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Admin\Partner::class);
            $table->foreignIdFor(\App\Models\User::class);
            $table->string('phone')->unique();
            $table->boolean('status')->default(0);
            $table->jsonb('setting_info')->nullable();
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
        Schema::dropIfExists('partner_user');
    }
}
