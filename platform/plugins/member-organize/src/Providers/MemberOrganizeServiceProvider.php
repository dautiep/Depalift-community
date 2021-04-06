<?php

namespace Platform\MemberOrganize\Providers;

use Platform\MemberOrganize\Models\MemberOrganize;
use Illuminate\Support\ServiceProvider;
use Platform\MemberOrganize\Repositories\Caches\MemberOrganizeCacheDecorator;
use Platform\MemberOrganize\Repositories\Eloquent\MemberOrganizeRepository;
use Platform\MemberOrganize\Repositories\Interfaces\MemberOrganizeInterface;
use Platform\Base\Supports\Helper;
use Event;
use Platform\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Routing\Events\RouteMatched;

class MemberOrganizeServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(MemberOrganizeInterface::class, function () {
            return new MemberOrganizeCacheDecorator(new MemberOrganizeRepository(new MemberOrganize));
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('plugins/member-organize')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadRoutes(['web']);

        Event::listen(RouteMatched::class, function () {
//            if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
//                \Language::registerModule([MemberOrganize::class]);
//            }

            dashboard_menu()->registerItem([
                'id'          => 'cms-plugins-member-organize',
                'priority'    => 4,
                'parent_id'   => 'cms-plugins-post-associates-parent',
                'name'        => 'Hội viên tổ chức',
                'icon'        => null,
                'url'         => route('member-organize.index'),
                'permissions' => ['member-organize.index'],
            ]);
        });
    }
}
