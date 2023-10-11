<!DOCTYPE html>
<html>
<head>
	<title>Orders</title>
</head>
<body dir="rtl">
	<h1>{{$details['title']}}</h1>
	<table>
		<tr style="color:white; background: black; border:solid 2px;">
			<th>رقم الطلب</th>
			<th>المنشاة</th>
			<th>اسم ولي الامر</th>
			<th>رقم الهاتف</th>
		</tr>

		<tr>					
			<td>{{$details['Order']}}</td>
			<td>{{$details['Facility']}}</td>
			<td>{{$details['Graduain']}}</td>
			<td>{{$details['GraduainPhone']}}</td>
		</tr>
	</table>
</body>
</html>