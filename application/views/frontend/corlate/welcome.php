<?php
/**
 * Created by PhpStorm.
 * User: HP ENVY
 * Date: 24-10-17
 * Time: 9:50 AM
 */
?>
<style>
	html {
		box-sizing: border-box;
	}

	*, *:before, *:after {
		box-sizing: inherit;
	}

	.logmod {
		display: block;
		position: fixed;
		top: 0;
		right: 0;
		bottom: 0;
		left: 0;
		opacity: 1;
		background: rgba(0, 0, 0, 0.2);
		z-index: 1;
	}
	.logmod::after {
		clear: both;
		content: "";
		display: table;
	}
	.logmod__wrapper {
		display: block;
		background: #FFF;
		position: relative;
		max-width: 550px;
		border-radius: 4px;
		box-shadow: 0 0 18px rgba(0, 0, 0, 0.2);
		margin: 12px auto;
	}
	.logmod__close {
		display: block;
		position: absolute;
		right: 50%;
		background: url("http://imgh.us/close_white.svg") no-repeat scroll 0% 0% transparent;
		text-indent: 100%;
		white-space: nowrap;
		overflow: hidden;
		cursor: pointer;
		top: -72px;
		margin-right: -24px;
		width: 48px;
		height: 48px;
	}
	.logmod__container {
		overflow: hidden;
		width: 100%;
	}
	.logmod__container::after {
		clear: both;
		content: "";
		display: table;
	}
	.logmod__tab {
		position: relative;
		width: 100%;
		height: 0;
		overflow: hidden;
		opacity: 0;
		visibility: hidden;
	}
	.logmod__tab-wrapper {
		width: 100%;
		height: auto;
		overflow: hidden;
	}
	.logmod__tab.show {
		opacity: 1;
		height: 100%;
		visibility: visible;
	}
	.logmod__tabs {
		list-style: none;
		padding: 0;
		margin: 0;
	}
	.logmod__tabs::after {
		clear: both;
		content: "";
		display: table;
	}
	.logmod__tabs li.current a {
		background: #FFF;
		color: #333;
	}
	.logmod__tabs li a {
		width: 50%;
		position: relative;
		float: left;
		text-align: center;
		background: #D2D8D8;
		line-height: 72px;
		height: 72px;
		text-decoration: none;
		color: #809191;
		text-transform: uppercase;
		font-weight: 700;
		font-size: 16px;
		cursor: pointer;
	}
	.logmod__tabs li a:focus {
		outline: dotted 1px;
	}
	.logmod__heading {
		text-align: center;
		padding: 12px 0 12px 0;
	}
	.logmod__heading-subtitle {
		display: block;
		font-weight: 400;
		font-size: 15px;
		color: #888;
		line-height: 48px;
	}
	.logmod__form {
		border-top: 1px solid #e5e5e5;
	}
	.logmod__alter {
		display: block;
		position: relative;
		margin-top: 7px;
	}
	.logmod__alter::after {
		clear: both;
		content: "";
		display: table;
	}
	.logmod__alter .connect:last-child {
		border-radius: 0 0 4px 4px;
	}

	.connect {
		overflow: hidden;
		position: relative;
		display: block;
		width: 100%;
		height: 72px;
		line-height: 72px;
		text-decoration: none;
	}
	.connect::after {
		clear: both;
		content: "";
		display: table;
	}
	.connect:focus, .connect:hover, .connect:visited {
		color: #FFF;
		text-decoration: none;
	}
	.connect__icon {
		vertical-align: middle;
		float: left;
		width: 70px;
		text-align: center;
		font-size: 22px;
	}
	.connect__context {
		vertical-align: middle;
		text-align: center;
	}
	.connect.facebook {
		background: #3b5998;
		color: #FFF;
	}
	.connect.facebook a {
		color: #FFF;
	}
	.connect.facebook .connect__icon {
		background: #283d68;
	}
	.connect.googleplus {
		background: #dd4b39;
		color: #FFF;
	}
	.connect.googleplus a {
		color: #FFF;
	}
	.connect.googleplus .connect__icon {
		background: #b52f1f;
	}

	.simform {
		position: relative;
	}
	.simform__actions {
		padding: 15px;
		font-size: 14px;
	}
	.simform__actions::after {
		clear: both;
		content: "";
		display: table;
	}
	.simform__actions .sumbit {
		height: 48px;
		float: right;
		color: #FFF;
		width: 50%;
		font-weight: 700;
		font-size: 16px;
		background: #4CAF50;
		margin-top: 7px;
	}
	.simform__actions .sumbit::after {
		clear: both;
		content: "";
		display: table;
	}
	.simform__actions-sidetext {
		display: inline-block;
		float: left;
		width: 50%;
		padding: 0 10px;
		margin: 9px 0 0 0;
		color: #8C979E;
		text-align: center;
		line-height: 24px;
	}
	.simform__actions-sidetext::after {
		clear: both;
		content: "";
		display: table;
	}

	.sminputs {
		border-bottom: 1px solid #E5E5E5;
	}
	.sminputs::after {
		clear: both;
		content: "";
		display: table;
	}
	.sminputs .input {
		display: block;
		position: relative;
		width: 50%;
		height: 71px;
		padding: 11px 24px;
		border-right: 1px solid #e5e5e5;
		border-bottom: none;
		float: left;
		background-color: #FFF;
		border-radius: 0;
		box-sizing: border-box;
		-webkit-appearance: none;
		-moz-appearance: none;
		appearance: none;
	}
	.sminputs .input.active {
		background: #eee;
	}
	.sminputs .input.active .hide-password {
		background: #eee;
	}
	.sminputs .input.full {
		width: 100%;
	}
	.sminputs .input label {
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
		display: block;
		width: 100%;
		text-transform: uppercase;
		letter-spacing: 1px;
		font-weight: 700;
		font-size: 12px;
		cursor: pointer;
		line-height: 24px;
	}
	.sminputs .input input {
		postion: relative;
		display: inline-block;
		height: 24px;
		font-size: 15px;
		line-height: 19.2px;
		color: #555;
		border-radius: 4px;
		vertical-align: middle;
		box-shadow: none;
		box-sizing: border-box;
		width: 100%;
		height: auto;
		border: none;
		padding: 0;
		cursor: pointer;
		background-color: transparent;
		color: rgba(75, 89, 102, 0.85);
	}
	.sminputs .hide-password {
		display: inline-block;
		position: absolute;
		right: 0;
		top: 0;
		padding: 0 15px;
		border-left: 1px solid #e4e4e4;
		font-size: 14px;
		background: #FFF;
		overflow: hidden;
		color: #444;
		cursor: pointer;
		margin-top: 12px;
		line-height: 48px;
	}

	html {
		font-size: 16px;
		line-height: 24px;
		font-family: "Lato", sans-serif;
	}

	.btn, .simform__actions .sumbit {
		display: inline-block;
		line-height: normal;
		white-space: nowrap;
		vertical-align: middle;
		text-align: center;
		cursor: pointer;
		box-sizing: border-box;
		border: none;
		outline: none;
		outline-offset: 0;
		font-weight: 400;
		box-shadow: none;
		min-width: 90px;
		padding: 10px 14px;
	}
	.btn.full, .simform__actions .full.sumbit {
		width: 100%;
	}
	.btn.lg, .simform__actions .lg.sumbit {
		min-width: 125px;
		padding: 17px 14px;
		font-size: 22px;
		line-height: 1.3;
	}
	.btn.sm, .simform__actions .sm.sumbit {
		min-width: 65px;
		padding: 4px 12px;
		font-size: 14px;
	}
	.btn.xs, .simform__actions .xs.sumbit {
		min-width: 45px;
		padding: 2px 10px;
		font-size: 10px;
		line-height: 1.5;
	}
	.btn.circle, .simform__actions .circle.sumbit {
		overflow: hidden;
		width: 56px;
		height: 56px;
		min-width: 56px;
		line-height: 1;
		padding: 0;
		border-radius: 50%;
	}
	.btn.circle.lg, .simform__actions .circle.lg.sumbit {
		width: 78px;
		height: 78px;
		min-width: 78px;
	}
	.btn.circle.sm, .simform__actions .circle.sm.sumbit {
		width: 40px;
		height: 40px;
		min-width: 40px;
	}
	.btn.circle.xs, .simform__actions .circle.xs.sumbit {
		width: 30px;
		height: 30px;
		min-width: 30px;
	}
	.btn:focus, .simform__actions .sumbit:focus, .btn:active, .simform__actions .sumbit:active, .btn.active, .simform__actions .active.sumbit, .btn:active:focus, .simform__actions .sumbit:active:focus, .btn.active:focus, .simform__actions .active.sumbit:focus {
		outline: 0;
		outline-offset: 0;
		box-shadow: none;
	}
	.btn.red, .simform__actions .red.sumbit {
		background: #f44336;
		color: #FFF;
	}
	.btn.red:active, .simform__actions .red.sumbit:active, .btn.red:focus, .simform__actions .red.sumbit:focus {
		background-color: #ef1d0d;
	}
	.btn.red:hover, .simform__actions .red.sumbit:hover {
		background-color: #f32c1e;
	}
	.btn.pink, .simform__actions .pink.sumbit {
		background: #E91E63;
		color: #FFF;
	}
	.btn.pink:active, .simform__actions .pink.sumbit:active, .btn.pink:focus, .simform__actions .pink.sumbit:focus {
		background-color: #c61350;
	}
	.btn.pink:hover, .simform__actions .pink.sumbit:hover {
		background-color: #d81558;
	}
	.btn.purple, .simform__actions .purple.sumbit {
		background: #9C27B0;
		color: #FFF;
	}
	.btn.purple:active, .simform__actions .purple.sumbit:active, .btn.purple:focus, .simform__actions .purple.sumbit:focus {
		background-color: #7b1f8a;
	}
	.btn.purple:hover, .simform__actions .purple.sumbit:hover {
		background-color: #89229b;
	}
	.btn.deep-purple, .simform__actions .deep-purple.sumbit {
		background: #673AB7;
		color: #FFF;
	}
	.btn.deep-purple:active, .simform__actions .deep-purple.sumbit:active, .btn.deep-purple:focus, .simform__actions .deep-purple.sumbit:focus {
		background-color: #532f94;
	}
	.btn.deep-purple:hover, .simform__actions .deep-purple.sumbit:hover {
		background-color: #5c34a4;
	}
	.btn.indigo, .simform__actions .indigo.sumbit {
		background: #3F51B5;
		color: #FFF;
	}
	.btn.indigo:active, .simform__actions .indigo.sumbit:active, .btn.indigo:focus, .simform__actions .indigo.sumbit:focus {
		background-color: #334293;
	}
	.btn.indigo:hover, .simform__actions .indigo.sumbit:hover {
		background-color: #3849a2;
	}
	.btn.blue, .simform__actions .blue.sumbit {
		background: #2196F3;
		color: #FFF;
	}
	.btn.blue:active, .simform__actions .blue.sumbit:active, .btn.blue:focus, .simform__actions .blue.sumbit:focus {
		background-color: #0c7fda;
	}
	.btn.blue:hover, .simform__actions .blue.sumbit:hover {
		background-color: #0d8aee;
	}
	.btn.light-blue, .simform__actions .light-blue.sumbit {
		background: #03A9F4;
		color: #FFF;
	}
	.btn.light-blue:active, .simform__actions .light-blue.sumbit:active, .btn.light-blue:focus, .simform__actions .light-blue.sumbit:focus {
		background-color: #028ac7;
	}
	.btn.light-blue:hover, .simform__actions .light-blue.sumbit:hover {
		background-color: #0398db;
	}
	.btn.cyan, .simform__actions .cyan.sumbit {
		background: #00BCD4;
		color: #FFF;
	}
	.btn.cyan:active, .simform__actions .cyan.sumbit:active, .btn.cyan:focus, .simform__actions .cyan.sumbit:focus {
		background-color: #0093a6;
	}
	.btn.cyan:hover, .simform__actions .cyan.sumbit:hover {
		background-color: #00a5bb;
	}
	.btn.teal, .simform__actions .teal.sumbit {
		background: #009688;
		color: #FFF;
	}
	.btn.teal:active, .simform__actions .teal.sumbit:active, .btn.teal:focus, .simform__actions .teal.sumbit:focus {
		background-color: #00685e;
	}
	.btn.teal:hover, .simform__actions .teal.sumbit:hover {
		background-color: #007d71;
	}
	.btn.green, .simform__actions .green.sumbit {
		background: #4CAF50;
		color: #FFF;
	}
	.btn.green:active, .simform__actions .green.sumbit:active, .btn.green:focus, .simform__actions .green.sumbit:focus {
		background-color: #3e8f41;
	}
	.btn.green:hover, .simform__actions .green.sumbit:hover {
		background-color: #449d48;
	}
	.btn.light-green, .simform__actions .light-green.sumbit {
		background: #8BC34A;
		color: #FFF;
	}
	.btn.light-green:active, .simform__actions .light-green.sumbit:active, .btn.light-green:focus, .simform__actions .light-green.sumbit:focus {
		background-color: #74a838;
	}
	.btn.light-green:hover, .simform__actions .light-green.sumbit:hover {
		background-color: #7eb73d;
	}
	.btn.lime, .simform__actions .lime.sumbit {
		background: #CDDC39;
		color: #FFF;
	}
	.btn.lime:active, .simform__actions .lime.sumbit:active, .btn.lime:focus, .simform__actions .lime.sumbit:focus {
		background-color: #b6c423;
	}
	.btn.lime:hover, .simform__actions .lime.sumbit:hover {
		background-color: #c6d626;
	}
	.btn.yellow, .simform__actions .yellow.sumbit {
		background: #FFEB3B;
		color: #FFF;
	}
	.btn.yellow:active, .simform__actions .yellow.sumbit:active, .btn.yellow:focus, .simform__actions .yellow.sumbit:focus {
		background-color: #ffe60d;
	}
	.btn.yellow:hover, .simform__actions .yellow.sumbit:hover {
		background-color: #ffe822;
	}
	.btn.amber, .simform__actions .amber.sumbit {
		background: #FFC107;
		color: #FFF;
	}
	.btn.amber:active, .simform__actions .amber.sumbit:active, .btn.amber:focus, .simform__actions .amber.sumbit:focus {
		background-color: #d8a200;
	}
	.btn.amber:hover, .simform__actions .amber.sumbit:hover {
		background-color: #edb100;
	}
	.btn.orange, .simform__actions .orange.sumbit {
		background: #FF9800;
		color: #FFF;
	}
	.btn.orange:active, .simform__actions .orange.sumbit:active, .btn.orange:focus, .simform__actions .orange.sumbit:focus {
		background-color: #d17d00;
	}
	.btn.orange:hover, .simform__actions .orange.sumbit:hover {
		background-color: #e68900;
	}
	.btn.deep-orange, .simform__actions .deep-orange.sumbit {
		background: #FF5722;
		color: #FFF;
	}
	.btn.deep-orange:active, .simform__actions .deep-orange.sumbit:active, .btn.deep-orange:focus, .simform__actions .deep-orange.sumbit:focus {
		background-color: #f33a00;
	}
	.btn.deep-orange:hover, .simform__actions .deep-orange.sumbit:hover {
		background-color: #ff4409;
	}
	.btn.brown, .simform__actions .brown.sumbit {
		background: #795548;
		color: #FFF;
	}
	.btn.brown:active, .simform__actions .brown.sumbit:active, .btn.brown:focus, .simform__actions .brown.sumbit:focus {
		background-color: #5c4137;
	}
	.btn.brown:hover, .simform__actions .brown.sumbit:hover {
		background-color: #694a3e;
	}
	.btn.grey, .simform__actions .grey.sumbit {
		background: #9E9E9E;
		color: #FFF;
	}
	.btn.grey:active, .simform__actions .grey.sumbit:active, .btn.grey:focus, .simform__actions .grey.sumbit:focus {
		background-color: #878787;
	}
	.btn.grey:hover, .simform__actions .grey.sumbit:hover {
		background-color: #919191;
	}
	.btn.blue-grey, .simform__actions .blue-grey.sumbit {
		background: #607D8B;
		color: #FFF;
	}
	.btn.blue-grey:active, .simform__actions .blue-grey.sumbit:active, .btn.blue-grey:focus, .simform__actions .blue-grey.sumbit:focus {
		background-color: #4d6570;
	}
	.btn.blue-grey:hover, .simform__actions .blue-grey.sumbit:hover {
		background-color: #566f7c;
	}

	.special {
		color: #f44336;
		position: relative;
		text-decoration: none;
		transition: all 0.15s ease-out;
	}
	.special:before {
		content: "";
		position: absolute;
		width: 100%;
		height: 1px;
		bottom: 0px;
		left: 0;
		background: #f00;
		visibility: hidden;
		transform: scaleX(0);
		transition: all 0.3s ease-in-out 0s;
	}
	.special:hover {
		transition: all 0.15s ease-out;
	}
	.special:hover:before {
		visibility: visible;
		transform: scaleX(1);
	}

	#baseline {
		position: fixed;
		top: 0;
		bottom: 0;
		right: 0;
		left: 0;
		width: 100%;
		height: 100%;
		z-index: 999999;
		background-image: url(https://basehold.it/i/24);
	}
</style>
<div>
	<div class="logmod__wrapper wow fadeInDown">
		<div class="logmod__container">
			<ul class="logmod__tabs">
				<li data-tabtar="lgm-2"><a href="#">Login</a></li>
				<li data-tabtar="lgm-1"><a href="#">Sign Up</a></li>
			</ul>
			<div class="logmod__tab-wrapper">
				<div class="logmod__tab lgm-1">
					<div class="logmod__heading">
						<span class="logmod__heading-subtitle">Enter your personal details <strong>to create an acount</strong></span>
					</div>
					<div class="logmod__form">
						<form accept-charset="utf-8" action="#" class="simform">
							<div class="sminputs">
								<div class="input full">
									<label class="string optional" for="user-name">Email*</label>
									<input class="string optional" maxlength="255" id="user-email" placeholder="Email" type="email" size="50" />
								</div>
							</div>
							<div class="sminputs">
								<div class="input string optional">
									<label class="string optional" for="user-pw">Password *</label>
									<input class="string optional" maxlength="255" id="user-pw" placeholder="Password" type="text" size="50" />
								</div>
								<div class="input string optional">
									<label class="string optional" for="user-pw-repeat">Repeat password *</label>
									<input class="string optional" maxlength="255" id="user-pw-repeat" placeholder="Repeat password" type="text" size="50" />
								</div>
							</div>
							<div class="simform__actions">
								<input class="sumbit" name="commit" type="sumbit" value="Create Account" />
								<span class="simform__actions-sidetext">By creating an account you agree to our <a class="special" href="#" target="_blank" role="link">Terms & Privacy</a></span>
							</div>
						</form>
					</div>
					<div class="logmod__alter">
						<div class="logmod__alter-container">
							<a href="#" class="connect facebook">
								<div class="connect__icon">
									<i class="fa fa-facebook"></i>
								</div>
								<div class="connect__context">
									<span>Create an account with <strong>Facebook</strong></span>
								</div>
							</a>

							<a href="#" class="connect googleplus">
								<div class="connect__icon">
									<i class="fa fa-google-plus"></i>
								</div>
								<div class="connect__context">
									<span>Create an account with <strong>Google+</strong></span>
								</div>
							</a>
						</div>
					</div>
				</div>
				<div class="logmod__tab lgm-2">
					<div class="logmod__heading">
						<span class="logmod__heading-subtitle">Enter your email and password <strong>to sign in</strong></span>
					</div>
					<div class="logmod__form">
						<form accept-charset="utf-8" action="#" class="simform">
							<div class="sminputs">
								<div class="input full">
									<label class="string optional" for="user-name">Email*</label>
									<input class="string optional" maxlength="255" id="user-email" placeholder="Email" type="email" size="50" />
								</div>
							</div>
							<div class="sminputs">
								<div class="input full">
									<label class="string optional" for="user-pw">Password *</label>
									<input class="string optional" maxlength="255" id="user-pw" placeholder="Password" type="password" size="50" />
									<span class="hide-password">Show</span>
								</div>
							</div>
							<div class="simform__actions">
								<input class="sumbit" name="commit" type="sumbit" value="Log In" />
								<span class="simform__actions-sidetext"><a class="special" role="link" href="#">Forgot your password?<br>Click here</a></span>
							</div>
						</form>
					</div>
					<div class="logmod__alter">
						<div class="logmod__alter-container">
							<a href="#" class="connect facebook">
								<div class="connect__icon">
									<i class="fa fa-facebook"></i>
								</div>
								<div class="connect__context">
									<span>Sign in with <strong>Facebook</strong></span>
								</div>
							</a>
							<a href="#" class="connect googleplus">
								<div class="connect__icon">
									<i class="fa fa-google-plus"></i>
								</div>
								<div class="connect__context">
									<span>Sign in with <strong>Google+</strong></span>
								</div>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script >
	var LoginModalController = {
		tabsElementName: ".logmod__tabs li",
		tabElementName: ".logmod__tab",
		inputElementsName: ".logmod__form .input",
		hidePasswordName: ".hide-password",

		inputElements: null,
		tabsElement: null,
		tabElement: null,
		hidePassword: null,

		activeTab: null,
		tabSelection: 0, // 0 - first, 1 - second

		findElements: function () {
			var base = this;

			base.tabsElement = $(base.tabsElementName);
			base.tabElement = $(base.tabElementName);
			base.inputElements = $(base.inputElementsName);
			base.hidePassword = $(base.hidePasswordName);

			return base;
		},

		setState: function (state) {
			var base = this,
				elem = null;

			if (!state) {
				state = 0;
			}

			if (base.tabsElement) {
				elem = $(base.tabsElement[state]);
				elem.addClass("current");
				$("." + elem.attr("data-tabtar")).addClass("show");
			}

			return base;
		},

		getActiveTab: function () {
			var base = this;

			base.tabsElement.each(function (i, el) {
				if ($(el).hasClass("current")) {
					base.activeTab = $(el);
				}
			});

			return base;
		},

		addClickEvents: function () {
			var base = this;

			base.hidePassword.on("click", function (e) {
				var $this = $(this),
					$pwInput = $this.prev("input");

				if ($pwInput.attr("type") == "password") {
					$pwInput.attr("type", "text");
					$this.text("Hide");
				} else {
					$pwInput.attr("type", "password");
					$this.text("Show");
				}
			});

			base.tabsElement.on("click", function (e) {
				var targetTab = $(this).attr("data-tabtar");

				e.preventDefault();
				base.activeTab.removeClass("current");
				base.activeTab = $(this);
				base.activeTab.addClass("current");

				base.tabElement.each(function (i, el) {
					el = $(el);
					el.removeClass("show");
					if (el.hasClass(targetTab)) {
						el.addClass("show");
					}
				});
			});

			base.inputElements.find("label").on("click", function (e) {
				var $this = $(this),
					$input = $this.next("input");

				$input.focus();
			});

			return base;
		},

		initialize: function () {
			var base = this;

			base.findElements().setState().getActiveTab().addClickEvents();
		}
	};

	addPageHook(function(){
		LoginModalController.initialize();
		<?php
		if($param2 == "register"){
			echo "$('[data-tabtar=lgm-1]').trigger('click')";
		}
 ?>

	});
	</script>