@extends('layouts.app')

@section('content')
    
        <!-- Start Contact Area -->
        <section class="wn_contact_area bg--white pt--80 pb--80">
        	<div class="container">
        		<div class="row">
        			<div class="col-lg-8 col-12">
        				<div class="contact-form-wrap">
        					<h2 class="contact__title">Get in touch</h2>
        					<p>Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. </p>
                            <form id="" action="{{ route('contact') }}" method="post">
								@csrf
                                <div class="single-contact-form space-between">
									<div>                                   
										<input type="text" name="name" placeholder="Your Name*" value="{{ old('name') }}">
											@error('name')
												<span class="error-input text-danger">{{$message}}</span>										
											@enderror
									</div>
									<div>                                    
										<input type="email" name="email" placeholder="Email*" value="{{ old('email') }}">
											@error('email')
												<span class="error-input text-danger">{{$message}}</span>										
											@enderror
									</div>
                                </div>                                
                                <div class="single-contact-form">
                                    <input type="text" name="title" placeholder="Title*" value="{{ old('title') }}">
										@error('title')
											<span class="error-input text-danger">{{$message}}</span>										
										@enderror
                                </div>
                                <div class="single-contact-form message">
                                    <textarea name="message" placeholder="Type your message here.."> {{ old('message') }}</textarea>
										@error('message')
											<span class="error-input text-danger">{{$message}}</span>										
										@enderror
								</div>
                                {{-- <div class="contact-btn">
                                    <button type="submit">Send Email</button>
                                </div> --}}
								<input type="submit" value="Send Email" id="send-email"/>
                            </form>
                        </div> 
                        <div class="form-output">
                            <p class="form-messege"></p>
                        </div>
        			</div>
        			<div class="col-lg-4 col-12 md-mt-40 sm-mt-40">
        				<div class="wn__address">
        					<h2 class="contact__title">Get office info.</h2>
        					<p>Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima. </p>
        					<div class="wn__addres__wreapper">

        						<div class="single__address">
        							<i class="icon-location-pin icons"></i>
        							<div class="content">
        								<span>address:</span>
        								<p>{{ getSetting('address') }}</p>
        							</div>
        						</div>

        						<div class="single__address">
        							<i class="icon-phone icons"></i>
        							<div class="content">
        								<span>Phone Number:</span>
        								<p>716-298-1822</p>
        							</div>
        						</div>

        						<div class="single__address">
        							<i class="icon-envelope icons"></i>
        							<div class="content">
        								<span>Email address:</span>
        								<p>716-298-1822</p>
        							</div>
        						</div>

        						<div class="single__address">
        							<i class="icon-globe icons"></i>
        							<div class="content">
        								<span>website address:</span>
        								<p>716-298-1822</p>
        							</div>
        						</div>

        					</div>
        				</div>
        			</div>
        		</div>
        	</div>
        </section>
        <!-- End Contact Area -->

@endsection