<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->nestedSet();

            $table->string('name', 125)->nullable()->comment('名称');
            $table->string('title', 125)->nullable()->comment('中文名称');
            $table->string('url', 255)->nullable()->comment('URL');
            $table->string('file_path', 255)->nullable()->comment('文件路径');
            $table->string('redirection', 255)->nullable()->comment('重定向');
            $table->string('icon', 64)->nullable()->comment('菜单图标');
            $table->string('badge', 128)->nullable()->comment('徽章');

            $table->tinyInteger('dot', false)->default(0)->comment('小红点标记 0否1是');
            $table->tinyInteger('state', false)->default(1)->comment('状态 0隐藏 1显示');
            $table->tinyInteger('levelHidden', false)->default(0)->comment('始终显示当前节点 1是0否');
            $table->tinyInteger('isSvg', false)->default(0)->comment('是否自定义SVG图标 1是0否');
            $table->tinyInteger('noClosable', false)->default(0)->comment('固定 1是0否');
            $table->tinyInteger('breadcrumbHidden', false)->default(0)->comment('是否隐藏面包屑 1是0否');

            $table->string('activeMenu', 128)->nullable()->comment('活动页');
            $table->string('system', 64)->nullable()->comment('系统');
            $table->text('extend')->nullable()->comment('扩展属性');
            $table->integer('weigh', false)->default(0)->comment('权重');

            $table->tinyInteger('dynamicNewTab', false)->default(0)->comment('是否详情页根据id传参不同可打开多个 1是0否');
            $table->tinyInteger('noKeepAlive', false)->default(0)->comment('禁止自动播放 1是0否');
            $table->tinyInteger('hidden', false)->default(0)->comment('禁止 1是0否');
            $table->string('img', 64)->nullable()->comment('菜单封面');
            $table->string('type', 32)->nullable()->comment('类型：directory目录、menu菜单、button按钮');

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('role_has_menus', function (Blueprint $table) {
            $table->bigInteger('role_id')->default(0)->comment('角色ID');
            $table->bigInteger('menu_id')->default(0)->comment('菜单ID');
            $table->unique(['role_id', 'menu_id']);
        });

        Schema::create('menu_has_permissions', function (Blueprint $table) {
            $table->bigInteger('menu_id')->default(0)->comment('菜单ID');
            $table->bigInteger('permission_id')->default(0)->comment('权限ID');
            $table->unique(['menu_id', 'permission_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
        Schema::dropIfExists('role_has_menus');
        Schema::dropIfExists('menu_has_permissions');
    }
};
