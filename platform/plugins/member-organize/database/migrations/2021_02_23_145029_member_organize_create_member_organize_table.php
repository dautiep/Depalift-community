<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MemberOrganizeCreateMemberOrganizeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_member_organizes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_vietnam', 191)->nullable()->comment('Tên tiếng Việt');
            $table->string('name_english', 191)->nullable()->comment('Tên tiếng Anh');
            $table->string('name_sub', 191)->nullable()->comment('Tên viết tắt');
            $table->string('num_business', 191)->nullable()->comment('Quyết định thành lập/Giấy chứng nhận đăng ký doanh nghiệp số');
            $table->string('issued_by', 191)->nullable()->comment('Nơi cấp');
            $table->date('date_at')->nullable()->comment('Ngày cấp');
            $table->string('type_business', 191)->nullable()->comment('Loại hình doanh nghiệp');
            $table->string('pernament_main', 191)->nullable()->comment('Tỉnh/thành phố(địa chỉ trụ sở chính)');
            $table->string('district_main', 191)->nullable()->comment('Huyện/Quậń(địa chỉ trụ sở chính)');
            $table->string('address_main', 191)->nullable()->comment('Địa chỉ(địa chỉ trụ sở chính)');
            $table->string('pernament_sub', 191)->nullable()->comment('Tỉnh/thành phố(địa chỉ liên hệ)');
            $table->string('district_sub', 191)->nullable()->comment('Huyện/Quậń(địa chỉ liên hệ)');
            $table->string('address_sub', 191)->nullable()->comment('Địa chỉ(địa chỉ liên hệ)');
            $table->string('phone', 191)->nullable()->comment('Số điện thoại liên hệ');
            $table->string('fax', 191)->nullable()->comment('Số fax');
            $table->string('link_web', 191)->nullable()->comment('Link website');
            $table->string('representative', 191)->nullable()->comment('Người đại diện');
            $table->string('position', 191)->nullable()->comment('Chức vụ người đại diện');
            $table->string('name_member', 191)->nullable()->comment('Họ tên người đại diện tham gia');
            $table->string('position_member', 191)->nullable()->comment('Chức vụ người đại diện tham gia');
            $table->string('phone_member', 191)->nullable()->comment('Số điện thoại người đại diện tham gia');
            $table->text('career_main')->nullable()->comment('Các ngành nghề kinh doanh chính');
            $table->text('degree')->nullable()->comment('Các thành tích tiêu biểu');
            $table->text('purpose')->nullable()->comment('Mục đích tham gia');
            $table->string('file', 191)->nullable()->comment('Các giấy tờ liên quan');
            $table->string('status', 60)->default('published');
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
        Schema::dropIfExists('member_organizes');
    }
}
