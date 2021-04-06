<?php

namespace Platform\PostEvents;

use Platform\Dashboard\Repositories\Interfaces\DashboardWidgetInterface;
use Schema;
use Platform\PluginManagement\Abstracts\PluginOperationAbstract;

class Plugin extends PluginOperationAbstract
{
    public static function remove()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('app_post_events_category');
        Schema::dropIfExists('app_post_events');
        Schema::dropIfExists('app_category_events');

        app(DashboardWidgetInterface::class)->deleteBy(['name' => 'widget_posts_recent']);
    }
}
