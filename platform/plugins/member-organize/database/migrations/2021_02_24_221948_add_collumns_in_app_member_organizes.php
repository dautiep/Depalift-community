<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCollumnsInAppMemberOrganizes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('app_member_organizes', function (Blueprint $table) {
            $table->date('date_start_at')->nullable()->comment('Ngày cấp đầu tiên');
            $table->string('email', 191)->nullable()->comment('Email của người đại diện');
            $table->string('fanpage', 191)->nullable()->comment('Link fanpage');
            $table->string('email_member', 191)->nullable()->comment('Email của người đại diện tổ chức tham gia Hiệp hội');
            $table->text('logo_main')->nullable()->comment('Thương hiệu chính');
            $table->string('marketing_main', 191)->nullable()->comment('Thị trường chính');
            $table->text('shop')->nullable()->comment('Chi nhánh, văn phòng');
            $table->integer('total_staff')->nullable()->comment('Tổng số CBNV toàn đơn vị');
            $table->integer('total_staff_tech')->nullable()->comment('Số lượng nhân viên kỹ thuật thang máy');
            $table->text('activity')->nullable()->comment('Hoạt động chính');
            $table->text('activity_for_latest_years')->nullable()->comment('Tình hình hoạt động 3 năm gần nhất');

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
