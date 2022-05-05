<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
	<body>
		<?php
$db_conn = @mysqli_connect("localhost", "root", "(비밀번호)", "mysql");

if(!$db_conn){
	$error = mysqli_connect_error();
	$errno = mysqli_connect_errno();
	print "$errno: $error\n";
	exit();
}

$query = "SELECT user, host FROM user";  // WHERE column1 LIKE ? AND column2 > ?
$stmt = mysqli_prepare($db_conn, $query);

if($stmt === false){
	echo "Statement 생성 실패 : " . mysqli_error($db_conn);
	exit();
}

/*
$bind = mysqli_stmt_bind_param($stmt, "si", "value1", value2);

if($bind === false){
	echo "파라미터 바인드 실패 : " . mysqli_error($db_conn);
	exit();
}
*/

$exec = mysqli_stmt_execute($stmt);

if($exec === false){
	echo "쿼리 실행 실패 : " . mysqli_error($db_conn);
	exit();
}

$result = mysqli_stmt_get_result($stmt);

if($result){
	echo "조회된 행의 수 : ".mysqli_num_rows($result)."<br/><br/>";
	echo "(User) / (Host) <br/>";

	while($row = mysqli_fetch_assoc($result)){
		print $row["User"] . " / " . $row["Host"] . "<br/>";  // column명이 대소문자를 구분함!
	} 

	mysqli_free_result($result);
	mysqli_stmt_close($stmt);
}
else{
	echo "Error : " . mysqli_error($db_conn);
}
		?>
	</body>
</html>
