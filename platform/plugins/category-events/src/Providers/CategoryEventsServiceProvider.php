<?php

namespace Platform\CategoryEvents\Providers;

use Platform\CategoryEvents\Models\CategoryEvents;
use Illuminate\Support\ServiceProvider;
use Platform\CategoryEvents\Repositories\Caches\CategoryEventsCacheDecorator;
use Platform\CategoryEvents\Repositories\Eloquent\CategoryEventsRepository;
use Platform\CategoryEvents\Repositories\Interfaces\CategoryEventsInterface;
use Platform\Base\Supports\Helper;
use Event;
use Platform\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Routing\Events\RouteMatched;
use Language;
use SeoHelper;
use SlugHelper;

class CategoryEventsServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(CategoryEventsInterface::class, function () {
            return new CategoryEventsCacheDecorator(new CategoryEventsRepository(new CategoryEvents));
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {

        $this->setNamespace('plugins/category-events')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadRoutes(['web']);

        Event::listen(RouteMatched::class, function () {
            if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
                \Language::registerModule([CategoryEvents::class]);
            }

            dashboard_menu()->registerItem([
                'id'          => 'cms-plugins-category-events',
                'priority'    => 1,
                'parent_id'   => 'cms-plugins-post-events-parent',
                'name'        => 'Danh mục',
                'icon'        => null,
                'url'         => route('category-events.index'),
                'permissions' => ['category-events.index'],
            ]);
        });
        $this->app->booted(function () {
            \SlugHelper::registerModule(CategoryEvents::class);
            \SlugHelper::setPrefix(CategoryEvents::class, 'su-kien');
            $models = [CategoryEvents::class];
            SeoHelper::registerModule($models);
        });
    }
}
