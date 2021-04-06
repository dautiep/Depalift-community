<?php

namespace Platform\PostProducer\Providers;

use Platform\PostProducer\Models\PostProducer;
use Illuminate\Support\ServiceProvider;
use Platform\PostProducer\Repositories\Caches\PostProducerCacheDecorator;
use Platform\PostProducer\Repositories\Eloquent\PostProducerRepository;
use Platform\PostProducer\Repositories\Interfaces\PostProducerInterface;
use Platform\Base\Supports\Helper;
use Event;
use Platform\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Routing\Events\RouteMatched;
use Language;
use SeoHelper;
use SlugHelper;

class PostProducerServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(PostProducerInterface::class, function () {
            return new PostProducerCacheDecorator(new PostProducerRepository(new PostProducer));
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('plugins/post-producer')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadRoutes(['web']);

        Event::listen(RouteMatched::class, function () {
            if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
                \Language::registerModule([PostProducer::class]);
            }

            \Gallery::registerModule([PostProducer::class]);

            dashboard_menu()->registerItem([
                'id'          => 'cms-plugins-post-producer',
                'priority'    => 5,
                'parent_id'   => null,
                'name'        => 'NSX và cung cấp vật tư',
                'icon'        => 'fa fa-business-time',
                'url'         => route('post-producer.index'),
                'permissions' => ['post-producer.index'],
            ]);
        });
        $this->app->booted(function () {
            \SlugHelper::registerModule(PostProducer::class);
            // \SlugHelper::setPrefix(PostProducer::class, 'su-kien');
            SeoHelper::registerModule(PostProducer::class);
        });
    }
}
