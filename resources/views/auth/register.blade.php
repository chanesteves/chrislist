@extends("layouts.app")

@section('content')
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 hidden-xs hidden-sm">
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
			</div>
			<div class="row">
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
		<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
			<div class="well no-padding">
				<div id="pnl-register-message">
	                <center>
	                    <h1>You Are Now Registered!</h1>            
	                </center>
	                <br/>
	                <div class="row">
	                    <div class="col-12">
	                        <div class="message">
	                            
	                        </div>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-12 buttons-success text-center">
	                        <a href="/auth/login" class="btn btn-success"><i class="fa fa-sign-in"></i> Login</a>
	                    </div>
	                    <div class="col-12 buttons-error text-center">
	                        <button id="btn-register-back" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</button>
	                    </div>
	                </div>
	            </div>
				<div id="pnl-register-form">
					<form id="frm-register" class="smart-form client-form" method="POST">
						<header>
							Sign Up
						</header>

						<div class="row">
							<section class="col col-12">
								<center><a href="{{ url('auth/google') }}" class="btn btn-labeled btn-danger"> <span class="btn-label"><i class="fa fa-google"></i></span>Continue with Google </a></center>
							</section>
						</div>

						<div class="divider"><strong>OR</strong></div>					
						<fieldset>
							<center><h5>Sign-up Using Your Email</h5></center>
							<br/>
							<div class="row">
								<section class="col col-6">
									<label class="input">
										<div class="form-group">
											<input id="txt-first-name" type="text" name="first_name" placeholder="First Name">
										</div>
									</label>
								</section>
								<section class="col col-6">
									<label class="input">
										<div class="form-group">
											<input id="txt-last-name" type="text" name="last_name" placeholder="Last Name">
										</div>
									</label>
								</section>
							</div>

							<div class="row">
								<section class="col col-12">
									<label class="select">
										<div class="form-group">
											<select id="ddl-gender" name="gender">
												<option value="0" selected="" disabled="">Gender</option>
												<option value="1">Male</option>
												<option value="2">Female</option>
											</select> <i></i> 
										</div>
									</label>
								</section>
							</div>
						</fieldset>

						<fieldset>
							<section>
								<label class="input"> <i class="icon-append fa fa-envelope"></i>
									<div class="form-group">
										<input id="txt-email" type="email" name="email" placeholder="Email address">
									</div>
								</label>
							</section>

							<section>
								<label class="input"> <i class="icon-append fa fa-lock"></i>
									<div class="form-group">
										<div class="input-group" rel="tooltip" data-placement="bottom" data-original-title="<div class='text-left password-requirement'>Password must meet the following requirements: </br> <i class='has-lower-upper fa-fw fa fa-circle font-xs txt-color-greenLight'></i>Has lower case letters.<br><i class='has-lower-upper fa-fw fa fa-circle font-xs txt-color-greenLight'></i>At least one capital letter.<br><i class='has-number fa-fw fa fa-circle font-xs txt-color-greenLight'></i>Contains at least one number.<br><i class='has-symbol fa-fw fa fa-circle font-xs txt-color-greenLight'></i>Includes at least one symbol.<br></div>" data-html="true" >
											<input id="txt-password" type="password" name="password" placeholder="Password" id="password">

                                            <div class="font-xs"><span class="pass-label" style="display: none;">Password Strength: </span><strong><span id="result"></span> </strong> </div>
                                        </div>										
									</div>
								</label>
							</section>

							<section>
								<label class="input"> <i class="icon-append fa fa-lock"></i>
									<div class="form-group">
										<input id="txt-confirm-password" type="password" name="confirm_password" placeholder="Confirm password">
									</div>
								</label>
							</section>
						</fieldset>

						<footer>
							<button id="btn-register" type="submit" class="btn btn-primary">
								Register
							</button>
						</footer>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection