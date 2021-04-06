<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeCollumnDateAtInAppMemberOrganizes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('app_member_organizes', function (Blueprint $table) {
            $table->date('date_at')->nullable()->comment('Ngày cấp thay đổi')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('app_member_organizes', function (Blueprint $table) {
            //
        });
    }
}
