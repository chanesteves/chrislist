@extends("layouts.app")

@section('content')
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-7 col-lg-8 hidden-xs hidden-sm">
			<center><h1 class="txt-color-red login-header-big">Christian's To-Do List</h1></center>
			<div class="hero">
			
				<img src="/img/demo/laptop.gif" class="pull-right display-image" alt="" style="width: 100%;">

			</div>

			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					<h5 class="about-heading">Easy-To-Use To-Do App</h5>
					<p>
						An intuitive way to manage your tasks. Add, edit, delete, check and uncheck your to-do items in a fun way.
					</p>
					<br/>
				</div>
				
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					<h5 class="about-heading">Manage Multiple To-Do Lists</h5>
					<p>
						Do not limit yourself to only one to-do list. Have your multiple to-do lists in one app.
					</p>
					<br/>
				</div>
				
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					<h5 class="about-heading">Activity Tracking</h5>
					<p>
						Keep track of the actions you perform to your tasks. ChrisList logs your activities within the app.
					</p>
					<br/>
				</div>

				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					<h5 class="about-heading">To-Do List Printing</h5>
					<p>
						ChrisList allows you to download and/or print your to-do lists so you can have them even when you are offline.
					</p>
					<br/>
				</div>
				
			</div>

		</div>
		<div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
			<div class="well no-padding">
				<form action="/auth/login" id="frm-login" method="POST" class="smart-form client-form">
					<input id="hdn-token" type="hidden" name="_token" value="{{ csrf_token() }}">

					<header>
						Sign In
					</header>

					<div class="row">
						<section class="col col-12">
							<center><a href="{{ url('auth/google') }}" class="btn btn-labeled btn-danger"> <span class="btn-label"><i class="fa fa-google"></i></span>Continue with Google </a></center>
						</section>
					</div>

					<div class="divider"><strong>OR</strong></div>	

					<fieldset>
						<center><h5>Sign-in Using Your Email</h5></center>
						@if (Session::get('error'))
		                    <div class="row">
		                        <div class="col-12">
		                        	<div style="padding: 10px;">
			                            <div class="alert alert-danger">
		                                    <i class="fa fa-times-circle"></i>
		                                    {{ Session::get('error') }}                     
		                                </div>
		                            </div>
		                        </div>
		                    </div>
		                @endif
						<section>
							<label class="label">E-mail</label>
							<label class="input"> <i class="icon-append fa fa-user"></i>
								<div class="form-group">
									<input id="txt-username" type="email" name="username">
									<input id="hdn-username" type="hidden" name="social_username" value="{{ Session::has('username') ? Session::get('username') : '' }}">
								</div>
							</label>
						</section>

						<section>
							<label class="label">Password</label>
							<label class="input"> <i class="icon-append fa fa-lock"></i>
								<div class="form-group">
									<input id="txt-password" type="password" name="password">
								</div>
							</label>
						</section>
					</fieldset>
					<footer>
						<button type="submit" class="btn btn-primary">
							Sign in
						</button>
					</footer>
				</form>

			</div>			
		</div>
	</div>
@endsection