<?php

namespace Platform\CategoryTraining\Providers;

use Platform\CategoryTraining\Models\CategoryTraining;
use Illuminate\Support\ServiceProvider;
use Platform\CategoryTraining\Repositories\Caches\CategoryTrainingCacheDecorator;
use Platform\CategoryTraining\Repositories\Eloquent\CategoryTrainingRepository;
use Platform\CategoryTraining\Repositories\Interfaces\CategoryTrainingInterface;
use Platform\Base\Supports\Helper;
use Event;
use Platform\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Routing\Events\RouteMatched;
use Language;
use SeoHelper;
use SlugHelper;

class CategoryTrainingServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(CategoryTrainingInterface::class, function () {
            return new CategoryTrainingCacheDecorator(new CategoryTrainingRepository(new CategoryTraining));
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('plugins/category-training')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadRoutes(['web']);

        Event::listen(RouteMatched::class, function () {
            if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
                \Language::registerModule([CategoryTraining::class]);
            }

            dashboard_menu()->registerItem([
                'id'          => 'cms-plugins-category-training',
                'priority'    => 1,
                'parent_id'   => 'cms-plugins-post-training-parent',
                'name'        => 'Danh mục',
                'icon'        => null,
                'url'         => route('category-training.index'),
                'permissions' => ['category-training.index'],
            ]);
        });
        $this->app->booted(function () {
            \SlugHelper::registerModule(CategoryTraining::class);
            // \SlugHelper::setPrefix(CategoryEvents::class, 'su-kien');
            $models = [CategoryTraining::class];
            SeoHelper::registerModule($models);
        });
    }
}
