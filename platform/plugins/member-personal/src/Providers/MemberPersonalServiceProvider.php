<?php

namespace Platform\MemberPersonal\Providers;

use Platform\MemberPersonal\Models\MemberPersonal;
use Illuminate\Support\ServiceProvider;
use Platform\MemberPersonal\Repositories\Caches\MemberPersonalCacheDecorator;
use Platform\MemberPersonal\Repositories\Eloquent\MemberPersonalRepository;
use Platform\MemberPersonal\Repositories\Interfaces\MemberPersonalInterface;
use Platform\Base\Supports\Helper;
use Event;
use Platform\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Routing\Events\RouteMatched;

class MemberPersonalServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(MemberPersonalInterface::class, function () {
            return new MemberPersonalCacheDecorator(new MemberPersonalRepository(new MemberPersonal));
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('plugins/member-personal')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadRoutes(['web']);

        Event::listen(RouteMatched::class, function () {
//            if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
//                \Language::registerModule([MemberPersonal::class]);
//            }

            dashboard_menu()->registerItem([
                'id'          => 'cms-plugins-member-personal',
                'priority'    => 5,
                'parent_id'   => 'cms-plugins-post-associates-parent',
                'name'        => 'Hội viên cá nhân',
                'icon'        => null,
                'url'         => route('member-personal.index'),
                'permissions' => ['member-personal.index'],
            ]);
        });
    }
}
