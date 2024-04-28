<?php

namespace Ouhaohan8023\EasyRbac\Command;

use Illuminate\Console\Command;
use Ouhaohan8023\EasyRbac\Model\EasyRbac;

/**
 * 将菜单从文件恢复到数据库中
 */
class MenuRecover extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'easy:menu-recover';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '将菜单从文件恢复到数据库中';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        EasyRbac::restoreMenus();
    }
}
