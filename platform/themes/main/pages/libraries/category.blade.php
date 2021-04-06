@extends('theme.main::layouts.default')
@section('content')
	<div class="container">
		<section class="row">
			<section class="header-bottom mrt5 mrb10 w-100">
				<div class="form-inline">
					<div class="col-md-9 hidden-sm-down">
						<ul class="breadcrumb">
							<li class="breadcrumb-sub-main">
								<a href="{{route('public.index')}}">
									<i class="fas fa-home"></i>
								</a>
							</li>
							<li class="breadcrumb-sub">
								<a href="#">
									<i class="fas fa-angle-right"></i>
									{{__("Thư viện")}}
								</a>
							</li>
							<li class="breadcrumb-sub">
								<a href="{{route('libraries.index', @$category->slug)}}">
									<i class="fas fa-angle-right"></i>
									{{ @$category->name }}
								</a>
							</li>

						</ul>
					</div>
					<div class="col-md-3 form-search">
						<form action="{{ route('search_library')}}">
							<div class="form-search--input" id="form-search">
								<input name="q" class="input-search" type="text" autocomplete="false" placeholder="{{__("Tìm kiếm")}}">
								<button type="submit">
									<a href="{{ route('search_library')}}">
										<i class="fas fa-search icon__search"></i>
									</a>
								</button>
							</div>
							<span class="btn-search __js_show_search" id="menu-search">{{__("Tìm kiếm")}}
								<i class="fas fa-search button-search"></i>
							</span>
						</form>
					</div>
				</div>
			</section>
		</section>
	</div>
	<section class="container">
		<section class="row">
			<div class="col-md-8">
				<div class="clearfix">
					<h2 class="title-line">{{__("Văn bản mới")}}</h2>
					<!-- List post -->
					<section class="row">
						@forelse(@$category_library as $post)
							<div class="col-lg-6 mrb20 content-area">
								<div class="new-image w-100 shine-hover">
									<a href="{{ route('libraries.detail', @$post->slug) }}">
										<img src="{{ RvMedia::getImageUrl(@$post->thumbnail,'featured', false, RvMedia::getImageUrl(theme_option('default_image'), 'featured')) }}"
										     alt="Văn bản" class="img-fluid center-block">
									</a>
								</div>

								<div class="new-content">
									<h2>
										<a class="new-content__name" href="{{ route('libraries.detail',@$post->slug) }}"
										   title="{{ @$post->name }}">{{ @$post->name }}</a>
									</h2>
									<div class="new-content-des">
										{{ @$post->description }}
									</div>
									<a href="{{ route('libraries.detail', @$post->slug) }}" class="new-content-readmore" title="{{ @$post->name }}">
										{{__("Xem thêm")}}
										<i class="fas fa-angle-right"></i>
									</a>
								</div>
							</div>
						@empty
							<div class="col-12">
								<p>{{ __("Không có dữ liệu") }}</p>
							</div>
						@endforelse
					</section>

					<!-- Pagination pane -->
					<div class="text-center">
						{{ $category_library->onEachSide(1)->links('theme.main::partials.pagination') }}
					</div>
				</div>
			</div>
			@includeIf('theme.main::pages.business')
		</section>
	</section>
@stop