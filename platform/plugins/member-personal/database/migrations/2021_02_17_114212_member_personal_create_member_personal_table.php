<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MemberPersonalCreateMemberPersonalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_member_personals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 120)->nullable()->comment('Họ và tên');
            $table->string('sex', 120)->nullable()->comment('Giới tính');
            $table->date('birth_day')->nullable()->comment('Ngày sinh');
            $table->string('place_birth',120)->nullable()->comment('Nơi sinh');
            $table->string('country',120)->nullable()->comment('Quốc tịch');
            $table->string('religion',120)->nullable()->comment('Tôn giáo');
            $table->string('identify',120)->nullable()->comment('CMND');
            $table->date('date_range')->nullable()->comment('Ngày cấp');
            $table->string('issued_by',120)->nullable()->comment('Nơi cấp');
            $table->string('pernament_main',120)->nullable()->comment('Tỉnh (địa chỉ thường trú)');
            $table->string('district_main',120)->nullable()->comment('Quận/Huyện (địa chỉ thường trú)');
            $table->string('address_main',120)->nullable()->comment('Địa chỉ thường trú (số nhà và đường)');
            $table->string('pernament_sub',120)->nullable()->comment('Tỉnh (địa chỉ hiện tại)');
            $table->string('district_sub',120)->nullable()->comment('Quận/Huyện (địa chỉ hiện tại)');
            $table->string('address_sub',120)->nullable()->comment('Địa chỉ hiện tại (số nhà và đường)');
            $table->string('mail',120)->nullable()->comment('email');
            $table->string('num_phone',120)->nullable()->comment('Số điện thoại');
            $table->string('link_fb',120)->nullable()->comment('Link facebook');
            $table->string('education',120)->nullable()->comment('Học vấn chuyên môn');
            $table->string('works',120)->nullable()->comment('Số năm làm việc');
            $table->string('work_place',120)->nullable()->comment('Nơi công tác hiện tại');
            $table->string('position',120)->nullable()->comment('Vị trí');
            $table->string('address_work',120)->nullable()->comment('Địa chỉ công tác hiện tại');
            $table->text('degree')->nullable()->comment('Bằng cấp');
            $table->text('capacity')->nullable()->comment('Năng lực thế mạnh');
            $table->text('purpose')->nullable()->comment('Mục đích tham gia');
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
        Schema::dropIfExists('app_member_personals');
    }
}
