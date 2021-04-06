<?php

namespace Platform\CategoryAssociates\Providers;

use Platform\CategoryAssociates\Models\CategoryAssociates;
use Illuminate\Support\ServiceProvider;
use Platform\CategoryAssociates\Repositories\Caches\CategoryAssociatesCacheDecorator;
use Platform\CategoryAssociates\Repositories\Eloquent\CategoryAssociatesRepository;
use Platform\CategoryAssociates\Repositories\Interfaces\CategoryAssociatesInterface;
use Platform\Base\Supports\Helper;
use Event;
use Platform\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Routing\Events\RouteMatched;
use Language;
use SeoHelper;
use SlugHelper;

class CategoryAssociatesServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(CategoryAssociatesInterface::class, function () {
            return new CategoryAssociatesCacheDecorator(new CategoryAssociatesRepository(new CategoryAssociates));
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('plugins/category-associates')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadRoutes(['web']);

        Event::listen(RouteMatched::class, function () {
            if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
                \Language::registerModule([CategoryAssociates::class]);
            }

            dashboard_menu()->registerItem([
                'id'          => 'cms-plugins-category-associates',
                'priority'    => 1,
                'parent_id'   => 'cms-plugins-post-associates-parent',
                'name'        => 'Danh mục',
                'icon'        => null,
                'url'         => route('category-associates.index'),
                'permissions' => ['category-associates.index'],
            ]);
        });
        $this->app->booted(function () {
            \SlugHelper::registerModule(CategoryAssociates::class);
            \SlugHelper::setPrefix(CategoryAssociates::class, 'hoi-vien');
            $models = [CategoryAssociates::class];
            SeoHelper::registerModule($models);
        });
    }
}
