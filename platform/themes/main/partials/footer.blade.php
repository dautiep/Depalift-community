<footer>	
	<div class="clearfix">
		<section class="container">
			<section class="row">
				<div class="col-lg-3 text-xs-center text-lg-left">
					<div class="mrb10 text-justify footer-summary">
						<a href="#" class="pull-xs-left imgg">
							<img src="{{RvMedia::getImageUrl(theme_option('logo'),'mini-logo', false, RvMedia::getImageUrl(theme_option('default_image'))) }}" alt="logo">
						</a>
						{{theme_option('footer_description')}}
					</div>
				<a href="{{ route('introduction.index_introduce')}}" class="button">
						{{__("Xem thêm")}}
						<em class="fa fa-angle-double-right" aria-hidden="true"></em>
					</a>
				</div>
				<div class="col-lg-9">
					<section>
						<section class="row home-list">
							{!!
								Menu::renderMenuLocation('footer-menu', [
									'options' => [],
									'theme'   => true,
									'view'	  => 'custom-footer',
								])
							!!}
						</section>
					</section>
				</div>
			</section>
			<div class="copyright text-xs-center">
				<div class="ModuleContent">
					<p class="m-0">
						@php
							echo theme_option('copyright_description') 
						@endphp	
					</p>
				</div>
			</div>
		</section>
	</div>
</footer>