<?php

namespace Platform\PostAssociates\Providers;

use Platform\PostAssociates\Models\PostAssociates;
use Illuminate\Support\ServiceProvider;
use Platform\PostAssociates\Repositories\Caches\PostAssociatesCacheDecorator;
use Platform\PostAssociates\Repositories\Eloquent\PostAssociatesRepository;
use Platform\PostAssociates\Repositories\Interfaces\PostAssociatesInterface;
use Platform\Base\Supports\Helper;
use Event;
use Platform\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Routing\Events\RouteMatched;
use Language;
use SeoHelper;
use SlugHelper;

class PostAssociatesServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(PostAssociatesInterface::class, function () {
            return new PostAssociatesCacheDecorator(new PostAssociatesRepository(new PostAssociates));
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('plugins/post-associates')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadRoutes(['web'])
            ->publishAssets()
            ->loadAndPublishViews();

        Event::listen(RouteMatched::class, function () {
            if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
                \Language::registerModule([PostAssociates::class]);
            }

            \Gallery::registerModule([PostAssociates::class]);

            dashboard_menu()->registerItem([
                'id'          => 'cms-plugins-post-associates-parent',
                'priority'    => 6,
                'parent_id'   => null,
                'name'        => 'Hội viên',
                'icon'        => 'fa fa-user-friends',
                'url'         => route('post-associates.index'),
                'permissions' => ['post-associates.index'],
            ])->registerItem([
                'id'          => 'cms-plugins-post-associates',
                'priority'    => 2,
                'parent_id'   => 'cms-plugins-post-associates-parent',
                'name'        => 'Danh sách hội viên',
                'icon'        => null,
                'url'         => route('post-associates.index'),
                'permissions' => ['post-associates.index'],
            ]);
        });
        $this->app->booted(function () {
            \SlugHelper::registerModule(PostAssociates::class);
            \SlugHelper::setPrefix(PostAssociates::class, 'hoi-vien');
            SeoHelper::registerModule(PostAssociates::class);
        });
    }
}
