<?php

// Custom routes
// You can delete this route group if you don't need to add your custom routes.

use Platform\Blog\Models\Category;
use Platform\CategoryAssociates\Models\CategoryAssociates;
use Platform\CategoryEvents\Models\CategoryEvents;
use Platform\CategoryTraining\Models\CategoryTraining;
use Platform\Contact\Http\Controllers\ContactController;

Route::group(
	['namespace' => 'Theme\Main\Http\Controllers', 'middleware' => 'web'],
	function () {
		Route::group(
			apply_filters(BASE_FILTER_GROUP_PUBLIC_ROUTE, []),
			function () {
				// Add your custom route here
				// Ex: Route::get('hello', 'MainController@getHello');
				Route::group(
					[
						'prefix' => 'tin-tuc',
						'as' => 'news.'
					],
					function () {
						$categories_news = Category::with('slugable')->get()->pluck('slug');
						$excude_news = $categories_news->join('|');
						Route::get('/', 'NewsController@index')->name('index');
						Route::get('bai-viet/{category}', 'NewsController@category')->where('category', $excude_news)->name('category');
						Route::get('{slug}', 'NewsController@detail_news')->name('detail_news');
					}
				);

				Route::group(
					[
						'prefix' => 'gioi-thieu',
						'as' => 'introduction.'
					],
					function () {
						Route::get(
							'gioi-thieu-hiep-hoi',
							[
								'as' => 'index_introduce',
								'uses' => 'PagesController@index'
							]
						);
						Route::get(
							'dieu-le-hoat-dong',
							[
								'as' => 'operatingCharter',
								'uses' => 'PagesController@operatingCharter'
							]
						);
						Route::get(
							'phuong-huong-hoat-dong',
							[
								'as' => 'directionOfOperation',
								'uses' => 'PagesController@directionOfOperation'
							]
						);
						Route::get(
							'co-cau-to-chuc',
							[
								'as' => 'organizationalStructure',
								'uses' => 'PagesController@organizationalStructure'
							]
						);
					}
				);

				Route::group(
					[
						'prefix' => 'nsx-va-cung-cap-vat-tu',
						'as' => 'producer.'
					],
					function () {
						Route::get('/', 'ProducerController@index')->name('index');
						Route::get('{slug}', 'ProducerController@detail')->name('detail');
					}
				);

				Route::group(
					[
						'prefix' => 'lien-he',
						'as' => 'contact.'
					],
					function () {
						Route::get(
							'/',
							[
								'as' => 'index',
								'uses' => 'ContactController@index'
							]
						);

					}
				);
				
				Route::post('/', 'ContactController@submit_contacts')->name('submit_contacts');

				Route::group(
					[
						'prefix' => 'su-kien',
						'as' => 'events.'
					],
					function () {
						$categories = CategoryEvents::with('slugable')->get()->pluck('slug');
						$excude = $categories->join('|');
						//dd($excude);
						Route::get('/', 'EventsController@index')->name('index');
						Route::get('{category}', 'EventsController@category')->where('category', $excude)->name('category');
						Route::get('{slug}', 'EventsController@detail')->name('detail');
					}
				);

				Route::group(
					[
						'prefix' => 'dao-tao-tap-huan',
						'as' => 'training.'
					],
					function () {
						$categories_training = CategoryTraining::with('slugable')->get()->pluck('slug');
						$excude_training = $categories_training->join('|');
						Route::get('/', 'TrainingController@index_training')->name('index');
						Route::get('{category_training}', 'TrainingController@category_training')->where('category_training', $excude_training)->name('category_training');
						Route::get('{slug}', 'TrainingController@detail_training')->name('detail_training');
					}
				);

				Route::group(
					[
						'prefix' => 'hoi-vien',
						'as' => 'associate.'
					],
					function () {
						$categories_associate = CategoryAssociates::with('slugable')->get()->pluck('slug');
						$excude_associate = $categories_associate->join('|');
						Route::get('/', 'AssociateController@index_associate')->name('index');
						Route::get('{category_associate}', 'AssociateController@category_associate')->where('category_associate', $excude_associate)->name('category_associate');
					}
				);

				Route::group(
					[
						'prefix' => 'thu-vien',
						'as' => 'libraries.'
					],
					function () {
						Route::get('tai-lieu/{category}', 'LibraryController@category')->name('index');
						Route::get('{slug}', 'LibraryController@detail')->name('detail');
					}
				);
				

				Route::get('dang-ky-hoi-vien', 'AssociateController@register')->name('register_member');
				Route::get('quy-dinh-tro-thanh-hoi-vien', 'AssociateController@rule')->name('rule');
				Route::get('dang-ky-hoi-vien-truc-tuyen', 'AssociateController@getViewPersonal')->name('member-pesonal');
				Route::post('dang-ky-hoi-vien-ca-nhan-truc-tuyen', 'AssociateController@submitFormPersonal')->name('submit-form-personal');
				Route::post('dang-ky-hoi-vien-to-chuc-truc-tuyen', 'AssociateController@submitFormOrganize')->name('submit-form-organize');

				Route::post('show-districts-in-province-thuong-tru', 'AssociateController@getDistrictsInProvinceThuongTru')->name('show-district-thuong-tru');
                Route::post('show-districts-in-province-tam-tru', 'AssociateController@getDistrictsInProvinceTamTru')->name('show-district-tam-tru');

				Route::get('faq', 'ContactController@faq');

				Route::get('tim-kiem', 'MainController@getViewSearch')->name('result_search');
				Route::get('tim-kiem-hoi-vien', 'AssociateController@search_member')->name('search_member');
				Route::get('tim-kiem-su-kien', 'EventsController@search')->name('search');
				Route::get('tim-kiem-tin-tuc', 'NewsController@search_news')->name('search_news');
				Route::get('tim-kiem-nsx', 'ProducerController@search_producer')->name('search_producer');
				Route::get('tim-kiem-dao-tao-tap-huan', 'TrainingController@search_training')->name('search_training');
				Route::get('tim-kiem-thu-vien', 'LibraryController@search_library')->name('search_library');
			}
		);
	}
);

// Theme::routes();

Route::group(
	['namespace' => 'Theme\Main\Http\Controllers', 'middleware' => 'web'],
	function () {
		Route::group(
			apply_filters(BASE_FILTER_GROUP_PUBLIC_ROUTE, []),
			function () {
				Route::get('/', 'MainController@getIndex')
					->name('public.index');

				Route::get('sitemap.xml', 'MainController@getSiteMap')
					->name('public.sitemap');

				Route::get('{slug?}'.config('core.base.general.public_single_ending_url'), 'MainController@getView')
					->name('public.single');
			}
		);
	}
);