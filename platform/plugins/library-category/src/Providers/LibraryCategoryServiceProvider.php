<?php

namespace Platform\LibraryCategory\Providers;

use Language;
use Platform\LibraryCategory\Models\LibraryCategory;
use Illuminate\Support\ServiceProvider;
use Platform\LibraryCategory\Repositories\Caches\LibraryCategoryCacheDecorator;
use Platform\LibraryCategory\Repositories\Eloquent\LibraryCategoryRepository;
use Platform\LibraryCategory\Repositories\Interfaces\LibraryCategoryInterface;
use Platform\Base\Supports\Helper;
use Event;
use Platform\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Routing\Events\RouteMatched;
use SeoHelper;
use SlugHelper;

class LibraryCategoryServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(LibraryCategoryInterface::class, function () {
            return new LibraryCategoryCacheDecorator(new LibraryCategoryRepository(new LibraryCategory));
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('plugins/library-category')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadRoutes(['web']);

		$this->app->booted(function () {
			SlugHelper::registerModule(LibraryCategory::class);
			SlugHelper::setPrefix(LibraryCategory::class, 'thu-vien');
		});

		SeoHelper::registerModule([LibraryCategory::class]);

        Event::listen(RouteMatched::class, function () {
            if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
                Language::registerModule([LibraryCategory::class]);
            }

            dashboard_menu()->registerItem([
                'id'          => 'cms-plugins-library-category-parent',
                'priority'    => 9,
                'parent_id'   => null,
                'name'        => 'Quản lý tài liệu',
                'icon'        => 'fas fa-book',
                'url'         => null,
                'permissions' => ['library-category.index'],
            ])->registerItem(
				[
					'id' => 'cms-plugins-library-category',
					'priority' => 0,
					'parent_id' => 'cms-plugins-library-category-parent',
					'name' => 'Loại tài liệu',
					'icon' => null,
					'url' => route('library-category.index'),
					'permissions' => ['library-category.index'],
				]
			);
        });
    }
}
