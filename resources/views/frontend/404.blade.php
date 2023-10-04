@extends('layouts.app')

@section('content')
		<!-- Start Error Area -->
		<section class="page_error section-padding--lg bg--white">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-8 white-shadow-form shadow-1 pb-4">
						<div class="error__inner text-center">
							<div class="error__logo">
								<img src="{{asset('assets/default/404.jpg')}}" alt="error images">
							</div>
							<div class="error__content mb-4">
								<h2 class="m-0">error - not found</h2>
								<p>It looks like you are lost! Try searching here</p>
								<div class="search_form_wrapper">
									<form action="{{route('home')}}" method="GET">
										<div class="form__box">
											<input type="text" placeholder="Search..." name="search">
											<button><i class="fa fa-search"></i></button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End Error Area -->
@endsection