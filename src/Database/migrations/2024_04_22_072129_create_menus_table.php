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

            // //首字母大写，一定要与vue文件export的name对应起来，name名不可重复，用于noKeepAlive缓存控制（该项特别重要）
            $table->string('name', 125)->nullable()->comment('名称');
            ////注意根路由（第一条数据）是斜线，第一级路由必须带斜线，第二级路由开始不能带斜线，并且path名不可重复，框架会自动将父级与子级进行拼接，path只能是一个单词切勿配置成`/a/b/c`这种写法
            $table->string('path', 255)->nullable()->comment('path');
            //后端路由时此项为字符串，前端路由时此项为import的function，第一级路由是为Layout，其余为层级为vue的文件路径
            $table->string('component', 255)->nullable()->comment('文件路径');
            //重定向到子路由，格式从第一级路由开始拼接（默认可不写）
            $table->string('redirect', 255)->nullable()->comment('重定向');
            $table->tinyInteger('hidden')->default(0)->comment('是否显示在菜单中显示路由（默认值：false）');
            $table->tinyInteger('levelHidden')->default(0)->comment('是否显示在菜单中显示隐藏一级路由（默认值：false）');
            $table->string('title', 255)->nullable()->comment('菜单、面包屑、多标签页显示的名称');
            $table->string('icon', 64)->nullable()->comment('菜单图标');
            // 是否是自定义svg图标（默认值：false，如果设置true，那么需要把你的svg拷贝到icon下，然后icon字段配置上你的图标名）
            $table->tinyInteger('isCustomSvg')->default(0)->comment('是否自定义SVG图标 1是0否');
            $table->tinyInteger('noKeepAlive')->default(0)->comment('当前路由是否不缓存（默认值：false）');
            $table->tinyInteger('noClosable')->default(0)->comment('当前路由是否可关闭多标签页，同上（2021年10月后新版支持）');
            $table->tinyInteger('noColumn')->default(0)->comment('当前路由是否可关闭多标签页，同上（2021年10月后新版支持）');
            $table->string('badge', 128)->nullable()->comment('badge小标签（只支持子级，String类型，支持自定义）');
            $table->tinyInteger('tabHidden')->default(0)->comment('当前路由是否不显示多标签页（默认值：false，不推荐使用）');
            $table->string('activeMenu', 256)->nullable()->comment('高亮指定菜单，要从跟路由的path开始拼接（用于隐藏页高亮）');
            $table->tinyInteger('dot')->default(0)->comment('小红点标记 0否1是');
            $table->tinyInteger('dynamicNewTab')->default(0)->comment('是否详情页根据id传参不同可打开多个 1是0否');
            $table->tinyInteger('breadcrumbHidden')->default(0)->comment('是否隐藏面包屑 1是0否');
            $table->tinyInteger('fullscreen')->default(0)->comment('是否全屏 1是0否');

            $table->string('system', 64)->nullable()->comment('系统');
            $table->integer('weigh', false)->default(0)->comment('权重');
            $table->string('img', 256)->nullable()->comment('菜单封面');
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
