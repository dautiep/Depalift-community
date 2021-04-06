<?php

namespace Platform\MemberOrganize;

use Schema;
use Platform\PluginManagement\Abstracts\PluginOperationAbstract;

class Plugin extends PluginOperationAbstract
{
    public static function remove()
    {
        Schema::dropIfExists('member_organizes');
    }
}
