<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropCollumnsInAppMemberOrganizes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('app_member_organizes', 'fax')){
            Schema::table('app_member_organizes', function (Blueprint $table) {
                $table->dropColumn('fax');
            });
        }
        
        if (Schema::hasColumn('app_member_organizes', 'degree')){
            Schema::table('app_member_organizes', function (Blueprint $table) {
                $table->dropColumn('degree');
            });
        }
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
