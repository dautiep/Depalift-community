<?php

namespace Platform\LibraryDocument\Providers;

use CustomField;
use Language;
use Platform\LibraryDocument\Models\LibraryDocument;
use Illuminate\Support\ServiceProvider;
use Platform\LibraryDocument\Repositories\Caches\LibraryDocumentCacheDecorator;
use Platform\LibraryDocument\Repositories\Eloquent\LibraryDocumentRepository;
use Platform\LibraryDocument\Repositories\Interfaces\LibraryDocumentInterface;
use Platform\Base\Supports\Helper;
use Event;
use Platform\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Routing\Events\RouteMatched;
use SlugHelper;
use SeoHelper;

class LibraryDocumentServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(LibraryDocumentInterface::class, function () {
            return new LibraryDocumentCacheDecorator(new LibraryDocumentRepository(new LibraryDocument));
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('plugins/library-document')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadRoutes(['web']);

		$this->app->booted(function () {
			SlugHelper::registerModule(LibraryDocument::class);
			SlugHelper::setPrefix(LibraryDocument::class, 'thu-vien');

			if (defined('CUSTOM_FIELD_MODULE_SCREEN_NAME')) {
				CustomField::registerModule(LibraryDocument::class)
					->registerRule('basic', __('Loại tài liệu'), LibraryDocument::class, function () {
						return $this->app->make(LibraryDocumentInterface::class)->pluck('name', 'id');
					})
					->expandRule('other', 'Model', 'model_name', function () {
						return [
							LibraryDocument::class => __('Danh sách tài liệu'),
						];
					});
			}
		});

		SeoHelper::registerModule([LibraryDocument::class]);

        Event::listen(RouteMatched::class, function () {
            if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
                Language::registerModule([LibraryDocument::class]);
            }

            dashboard_menu()->registerItem([
                'id'          => 'cms-plugins-library-document',
                'priority'    => 1,
                'parent_id'   => 'cms-plugins-library-category-parent',
                'name'        => 'Danh sách document',
                'icon'        => null,
                'url'         => route('library-document.index'),
                'permissions' => ['library-document.index'],
            ]);
        });
    }
}
