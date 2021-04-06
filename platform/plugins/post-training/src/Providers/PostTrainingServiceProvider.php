<?php

namespace Platform\PostTraining\Providers;

use Platform\PostTraining\Models\PostTraining;
use Illuminate\Support\ServiceProvider;
use Platform\PostTraining\Repositories\Caches\PostTrainingCacheDecorator;
use Platform\PostTraining\Repositories\Eloquent\PostTrainingRepository;
use Platform\PostTraining\Repositories\Interfaces\PostTrainingInterface;
use Platform\Base\Supports\Helper;
use Event;
use Platform\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Routing\Events\RouteMatched;
use Language;
use SeoHelper;
use SlugHelper;

class PostTrainingServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(PostTrainingInterface::class, function () {
            return new PostTrainingCacheDecorator(new PostTrainingRepository(new PostTraining));
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {

        $this->setNamespace('plugins/post-training')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadRoutes(['web'])
            ->publishAssets()
            ->loadAndPublishViews();

        Event::listen(RouteMatched::class, function () {
            if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
                \Language::registerModule([PostTraining::class]);
            }
                \Gallery::registerModule([PostTraining::class]);
            dashboard_menu()
            ->registerItem([
                'id'          => 'cms-plugins-post-training-parent',
                'priority'    => 4,
                'parent_id'   => null,
                'name'        => 'Đào tạo tập huấn',
                'icon'        => 'fa fa-brain',
                'url'         => route('post-training.index'),
                'permissions' => ['post-training.index'],
            ])->registerItem([
                'id'          => 'cms-plugins-post-training',
                'priority'    => 2,
                'parent_id'   => 'cms-plugins-post-training-parent',
                'name'        => 'Danh sách bài viết',
                'icon'        => null,
                'url'         => route('post-training.index'),
                'permissions' => ['post-training.index'],
            ]);
        });
        $this->app->booted(function () {
            \SlugHelper::registerModule(PostTraining::class);
            \SlugHelper::setPrefix(PostTraining::class, 'dao-tao');
            SeoHelper::registerModule(PostTraining::class);
        });
    }
}
