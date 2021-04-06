<?php

namespace Platform\PostEvents\Providers;

use Platform\PostEvents\Models\PostEvents;
use Illuminate\Support\ServiceProvider;
use Platform\PostEvents\Repositories\Caches\PostEventsCacheDecorator;
use Platform\PostEvents\Repositories\Eloquent\PostEventsRepository;
use Platform\PostEvents\Repositories\Interfaces\PostEventsInterface;
use Platform\Base\Supports\Helper;
use Event;
use Platform\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Routing\Events\RouteMatched;
use Language;
use SeoHelper;
use SlugHelper;

class PostEventsServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(PostEventsInterface::class, function () {
            return new PostEventsCacheDecorator(new PostEventsRepository(new PostEvents));
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {

        $this->setNamespace('plugins/post-events')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadRoutes(['web']);

        Event::listen(RouteMatched::class, function () {
            if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
                Language::registerModule(PostEvents::class);
            }

            \Gallery::registerModule([PostEvents::class]);

            dashboard_menu()->registerItem([
                'id'          => 'cms-plugins-post-events-parent',
                'priority'    => 3,
                'parent_id'   => null,
                'name'        => 'Sự kiện',
                'icon'        => 'fa fa-calendar-alt',
                'url'         => route('post-events.index'),
                'permissions' => ['post-events.index'],
            ])->registerItem([
                'id'          => 'cms-plugins-post-events',
                'priority'    => 2,
                'parent_id'   => 'cms-plugins-post-events-parent',
                'name'        => 'Danh sách sự kiện',
                'icon'        => null,
                'url'         => route('post-events.index'),
                'permissions' => ['post-events.index'],
            ]);
        });
        $this->app->booted(function () {
            \SlugHelper::registerModule(PostEvents::class);
            \SlugHelper::setPrefix(PostEvents::class, 'su-kien');
            SeoHelper::registerModule(PostEvents::class);
        });
    }
}
