<section id='error' class='container'><h2 align="center"
                                          style="color: red; font-size: 26px; margin: 0px 0px 25px; padding: 5px 0px; font-family: Tahoma, Geneva, sans-serif; letter-spacing: normal;">
		API</h2>

	<p style="margin-bottom: 10px; padding: 0px;  Geneva, sans-serif; letter-spacing: normal;">You
		can interface an application, website or system with our messaging gateway by using our very flexible HTTP API
		connection. Once you're connected, you'll be able send sms, check account balance, get deliver reports and sent
		messages or check your balance.</p>

	<h3 align=""
	    style="color: red; font-weight: bold; font-size: 15px; margin: 30px 0px 5px; padding: 0px; font-family: Tahoma, Geneva, sans-serif; letter-spacing: normal;">
		CONNECTION METHOD</h3>

	<div align="left" class="payment"
	     style="display: inline; size: 60px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal;">
		
		<br><b>SPC API</b>&nbsp;http://<?= domain_name(); ?>/api/sendsms.php?username=yourUsername&amp;password=yourPassword&amp;sender=@@sender@@&amp;message=@@message@@&amp;recipient=@@recipient@@
		<hr>
		<p style="margin-bottom: 10px; padding: 0px;"><a href="https://sms.quickhostme.com/api/#atm"
		                                                 style="color: rgb(8, 174, 227); display: block; size: 24px;">GET
				METHOD</a><a href="https://sms.quickhostme.com/api/#get"
		                     style="color: rgb(8, 174, 227); display: block; size: 24px;">POST METHOD</a></p></div>
	<p><span style="font-family: Tahoma, Geneva, sans-serif; letter-spacing: normal;"></span></p>
	<blockquote
		style="border-top: 1px solid rgb(204, 204, 204); border-right: 1px solid rgb(204, 204, 204); border-bottom: 1px solid rgb(204, 204, 204); border-left-color: rgb(0, 0, 0); border-image: initial; padding: 19px; margin-top: 20px; margin-bottom: 0px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; letter-spacing: normal;">
		<span class="h_api" style="font-size: 18px;">GET METHOD</span>

		<p style="margin-bottom: 10px; padding: 0px;">Connect to send single or multiple sms messages through the
			following api url:<span style="color: rgb(0, 85, 128);">http://<?= domain_name(); ?>
				/api/sendsms.php?username=user&amp;password=1234&amp;sender=quicsms1&amp;message=testing&amp;recipient=2348030000000,23480xxxxxxxx&amp;report=1&amp;convert=1&amp;route=1</span>
		</p><span class="h_api" style="font-size: 18px;">POST METHOD</span>

		<p style="margin-bottom: 10px; padding: 0px;">Use this method to send sms messages where the length of "GET
			METHOD" is a limitation,<br>url:&nbsp;<span style="color: rgb(0, 85, 128);">http://<?= domain_name(); ?>/api/sendsms.php</span>&nbsp;<br>Data
			to post: username=user&amp;password=1234&amp;sender=quicsms1&amp;message=testing &amp;recipient=2348030000000,23480xxxxxxxx&amp;report=1&amp;convert=1&amp;route=1
		</p>

		<hr>
		<div class="t_api">The parameters are:&nbsp;<br>1. recipient : The destination phone numbers. Separate multiple
			numbers with comma(,)<br>3. username: Your <?=c()->get_setting("site_name");?> account username<br>4. password: Your <?=c()->get_setting("site_name");?> account
			password<br>5. sender: The sender ID to show on the receiver's phone<br>6. message: The text message to be
			sent<br>7. balance: Set to 'true' only when you want to check your credit balance<br>6. schedule: Specify
			this parameter only when you are scheduling an sms for later delivery. It should contain the date the
			message should be delivered. Supported format is "2010-10-01 12:30:00" i.e "YYYY-MM-DD HH:mm:ss"<br>7.
			convert: Specify and set this parameter to 1 only when you want to get the return code in string readable
			format instead of the raw numbers below;<br>8. report: Set this parameter to 1 to retrieve the message id
			which can later be used to retrieve the delivery report or else remove it or set it to 0<br>9. route: Set
			this parameter to&nbsp;<b>0</b>&nbsp;to send message using the normal route (Will not deliver to DND
			numbers). Set to&nbsp;<b>1</b>&nbsp;to send through normal route for numbers not on DND and send through
			banking route for numbers on DND. Set to&nbsp;<b>2</b>&nbsp;to send all messages through the banking route.
		</div>
		<div class="t_api"><br>The return values are:<br>OK = Successful<br>1 = Invalid Recipient(s) Number<br>2 = Cant
			send Empty Message<br>3 = Invalid Sender ID<br>4 = Insufficient Balance<br>5 = Incorrect Username or
			Password Specified<br>6 = Incorrect schedule date format<br>7 = Error sending message (Gateway not
			available), Please try again later<br><br>Example:<br>On success, the following code will be returned<br>OK
			21 = 4564<br><br>i.e 'OK' 'No of sms credits used' = 'Unique Message ID'&nbsp;<br>where OK = The message was
			sent successfully<br>21 = No of sms credits used<br>and 4564 = The unique message id of the sent message
			which can be used to retrieve the delivery status of the sent message.
		</div>
		<span style="color: red;">Note: When using GET METHOD to send message, the values should be properly encoded before sending it to our server</span>
		<hr>
		<br><span class="h_api" style="font-size: 18px;">CHECK ACCOUNT BALANCE</span>

		<p style="margin-bottom: 10px; padding: 0px;">You can use GET or POST METHOD to query your <?=c()->get_setting("site_name");?> account
			balance.<span style="color: rgb(0, 85, 128);">http://<?= domain_name(); ?>/api/sendsms.php?username=user&amp;password=1234&amp;balance=1</span>
		</p>

		<div class="t_api">The parameters are:&nbsp;<br>1. username: Your <?=c()->get_setting("site_name");?> account username<br>2. password:
			Your <?=c()->get_setting("site_name");?> account password<br>3. balance: This most be included to inform our server that you want to
			only check your account balance<br></div>
		<br>

		<div class="t_api"><i>On successful, Your account balance would be returned e.g&nbsp;<b>5024</b></i></div>
		<br>
		<hr>
		<span class="h_api" style="font-size: 18px;">DELIVERY REPORT</span>

		<p style="margin-bottom: 10px; padding: 0px;">Use Get Method to query the delivery report/status of the sent
			message using the message id.<span style="color: rgb(0, 85, 128);">http://<?= domain_name(); ?>/api/getdelivery.php?username=user&amp;password=1234&amp;msgid=4564</span>
		</p>

		<div class="t_api">The parameters are:&nbsp;<br>1. username: Your <?=c()->get_setting("site_name");?> account username<br>2. password:
			Your <?=c()->get_setting("site_name");?> account password<br>3. msgid: The message id of the sent message you want to retrieve the
			delivery status<br>3. html: Only Set this parameter to 1, to return the report in colourful html table
			format. e.g html=1<br></div>
		<br>

		<div class="t_api">On success, the following code will be returned.<br><i>2349038781252=DELIVERED=2015/10/25
				23:11:34, 2349055552635=SENT=----/--/-- --:--:--</i><br>i.e 'Number' = 'Delivery Status' = 'Date and
			Time of delivery'&nbsp;<br>where 2349038781252 = Phone number<br>DELIVERED = The message had delivered<br>2015/10/25
			23:11:34 = The date and time the message was delivered.
		</div>
	</blockquote>
</section>