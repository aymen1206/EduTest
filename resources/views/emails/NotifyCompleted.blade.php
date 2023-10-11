<!DOCTYPE html>
<html>
<head>
	<title>Orders</title>
	<meta charset="utf-8">
	<style type="text/css">
		@media screen {
			@font-face {
				  font-family: 'Calibri';
				  src: url('https://fonts.googleapis.com/css2?family=Calibri:wght@500&display=swap');
				}
				*{
						font-family: Calibri;
			      }
			}
		}
	</style>
</head>
<body style="background-color:grey" dir="rtl">
	<table align="center" border="0" cellpadding="0" cellspacing="0"
		width="550" bgcolor="white" style="border:2px solid black">
		<tbody>
			<tr>
				<td align="center">
					<table align="center" border="0" cellpadding="0"
						cellspacing="0" class="col-550" width="550">
						<tbody>
							<tr>
								<td align="center" style="background-color: #19bab2;
										height: 50px;">

									<a href="#" style="text-decoration: none;">
										<p style="color:white;
												font-weight:bold;">
											TheEdukey
										</p>
									</a>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr style="height: 300px;">
				<td align="center" style="border: none;
						border-bottom: 2px solid #19bab2;
						padding-right: 20px;padding-left:20px">

					<p style="font-weight: bolder;font-size: 42px;
							letter-spacing: 0.025em;
							color:black;">
							<div class="col-md-12" style="text-align: right;">		
							 <h2>عزيزنا العميل  {{$details['studentName']}} :</h2>
							 <h3>طلبك لدى  {{$details['eduFacility']}} مكتمل  .</h3>
							 <h3> رقم  الطلب  : {{$details['OrderId']}}</h3>
							</div>
							<div class="col-md-12" style="text-align: left;">
								<h2>: Dear {{$details['studentName_en']}} </h2> 
								<h3>.Your Request with {{$details['eduFacility_en']}} has been Completed</h3>
								<h3>Request No :{{$details['OrderId']}}</h3>
							</div>
						</div>
					</p>
				</td>
			</tr>

			<tr style="border: none;
			background-color: #19bab2;
			height: 40px;
			color:white;
			padding-bottom: 20px;
			text-align: center;">
				
<td height="40px" align="center">
	<p style="color:white;
	line-height: 1.5em;">

	<img  src="{{ $message->embed(public_path().'/images/logo_mail.png') }}" >
	 <p class="m-0">{{ __('lang.rights')}} </p>
	</p>
	<a href="{{ contact()->twitter }}"
	style="border:none;
		text-decoration: none;
		padding: 5px;">
			
	<img height="30"
	src=
"{{ $message->embed(public_path().'/images/twitter.png') }}"
	width="30" />
	</a>
	
	<a href="{{ contact()->youtube }}"
	style="border:none;
	text-decoration: none;
	padding: 5px;">
	
	<img height="30"
	src="{{ $message->embed(public_path().'/images/youtube.png') }}"
width="30" />
	</a>
	
	<a href="{{ contact()->facebook }}"
	style="border:none;
	text-decoration: none;
	padding: 5px;">
	
	<img height="20"
	src=
"{{ $message->embed(public_path().'/images/facebook.png') }}"
		width="24"
		style="position: relative;
			padding-bottom: 5px;" />
	</a>
	<a href="{{ contact()->insta }}"
	style="border:none;
	text-decoration: none;
	padding: 5px;">
	
	<img height="20"
	src="{{ $message->embed(public_path().'/images/instagram.png') }}"
		width="24"
		style="position: relative;
			padding-bottom: 5px;" />
	</a>


</td>
</tr>

		</tbody>
	</table>
</body>
</html>