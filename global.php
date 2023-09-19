<?php
	$server = "localhost";
	$user = "time_wp575";
	$pass = "qv639[-PSi";
	$dbname = $user;

	$rand = rand(0,9999);
	$now = date("ymdhi");
	$today = date("Y-m-d");

	if(isset($_REQUEST['id'])){
		$id = $_REQUEST['id'];
	}
	if(isset($_REQUEST['page'])){
		$page = $_REQUEST['page'];
	}else{
		$page = '';
	}
	$conn;
	
	function conndb() {
		global $conn;
		global $server;
		global $user;
		global $pass;
		global $dbname;
		
		$conn = mysqli_connect($server,$user,$pass,$dbname);
		mysqli_set_charset($conn, "utf8");
	}
	
	function closedb() {
		global $conn;
		mysqli_close($conn);
	}

    function webdate($date){
        $dt = explode('-',$date);
        return $dt[2].'/'.$dt[1].'/'.$dt[0];                
    }	
    function sqldate($date){
        $dt = explode('/',$date);
        return $dt[2].'-'.$dt[1].'-'.$dt[0];                
    }	

	$tmonth = [
		'01' => 'มกราคม',
		'02' => 'กุมภาพันธ์',
		'03' => 'มีนาคม',
		'04' => 'เมษายน',
		'05' => 'พฤษภาคม',
		'06' => 'มิถุนายน',
		'07' => 'กรกฎาคม',
		'08' => 'สิงหาคม',
		'09' => 'กันยายน',
		'10' => 'ตุลาคม',
		'11' => 'พฤศจิกายน',
		'12' => 'ธันวาคม',
	];
	$tmo = [
		'01' => 'ม.ค.',
		'02' => 'ก.พ.',
		'03' => 'มี.ค.',
		'04' => 'เม.ย.',
		'05' => 'พ.ค.',
		'06' => 'มิ.ย.',
		'07' => 'ก.ค.',
		'08' => 'ส.ค.',
		'09' => 'ก.ย.',
		'10' => 'ต.ค.',
		'11' => 'พ.ย.',
		'12' => 'ธ.ค.',
	];
	
	$emo = [
		'01' => 'JAN',
		'02' => 'FEB',
		'03' => 'MAR',
		'04' => 'APR',
		'05' => 'MAY',
		'06' => 'JUN',
		'07' => 'JUL',
		'08' => 'AUG',
		'09' => 'SEP',
		'10' => 'OCT',
		'11' => 'NOV',
		'12' => 'DEC',
	];