<?php

namespace Ouhaohan8023\EasyRbac\Command;

use Illuminate\Console\Command;
use Ouhaohan8023\EasyRbac\Model\EasyRbac;

/**
 * 将菜单从数据库导出到文件中
 */
class MenuPersist extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'easy:menu-persist';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '将菜单从数据库导出到文件中';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        EasyRbac::persistenceMenus();
    }
}
