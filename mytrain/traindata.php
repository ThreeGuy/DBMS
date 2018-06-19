<?php
	//Program by yueyuan 2010.12.20
	header('Content-Type:text/html;charset=GB2312');
	require("showdata.php");
	

	//连接数据库
	$dbhost = 'localhost';
	$dbuser = 'admin';
	$dbpass = 'windows';
	$dbname = 'mytrain';
 // $mysql_query("set names'gbk2312'");
	$conn = mysqli_connect($dbhost,$dbuser,$dbpass) or die('cannot connect to database:'.mysqli_error());

	//设置数据库字符集
	//# mysql_query("SET NAMES 'GB2312'"); 
	mysqli_query($conn, "SET NAMES 'GB2312'");

	//选定数据库
	mysqli_select_db($conn, $dbname);


	$action = $_GET["action"];
	

	//功能选择
	switch($action){
		case "list":
			
			$start = $_GET["start"];
			$end = $_GET["end"];

			$sql = "SELECT * FROM through TT,train WHERE TT.TrainNum = train.TrainNum AND EXISTS (SELECT * FROM through TS,station SS WHERE TS.TrainNum = TT.TrainNum AND TS.Station = SS.Name AND SS.City = '".$start."' AND TS.Order <= TT.Order AND EXISTS (SELECT * FROM through TE,station SE WHERE TE.TrainNum = TT.TrainNum AND TE.Station = SE.Name AND SE.City = '".$end."' AND TE.Order > TS.Order AND TE.Order >= TT.Order)) ORDER BY TT.TrainNum,TT.Order";

			//查询
			//# $query = mysql_query($sql);
			$query = mysqli_query($conn, $sql);


			//处理数据，输出列表
			//# $allrows = mysql_num_rows($query);
			$allrows = mysqli_num_rows($query);
			

			if($allrows > 0){
				//# $sdata = mysql_fetch_assoc($query);
				$sdata = mysqli_fetch_assoc($query);
				$sposi = 0;

				for($i = 1;$i < $allrows;$i++){
					//# mysql_data_seek($query,$i);
					mysqli_data_seek($query, $i);
					
					//# $row = mysql_fetch_assoc($query);
					$row = mysqli_fetch_assoc($query);

					if($row["TrainNum"] != $sdata["TrainNum"]){
						//new train

						TrainHead($sdata,$enddata);

						$sdata = $row;
						
						TrainDetailList($query,$sposi,$i);
						
						$sposi = $i;
						
					}
					else
						$enddata = $row;
					
				}

				//last one
				TrainHead($sdata,$enddata);

				TrainDetailList($query,$sposi,$allrows);


			}
			
			break;

		case "station":

			$station = $_GET["station"];
			
			$sql = "SELECT * FROM through T1,train WHERE T1.TrainNum = train.TrainNum AND EXISTS (SELECT * FROM through T2 WHERE T2.TrainNum = T1.TrainNum AND Station = '".$station."') ORDER BY T1.TrainNum,T1.Order";

			//查询
			$query = mysqli_query($conn, $sql);


			//处理数据，输出列表
			$allrows = mysqli_num_rows($query);
			

			if($allrows > 0){
				
				//添加
				$query = mysqli_query($conn, $sql);
				//
				$sdata = mysqli_fetch_assoc($query);
				$sposi = 0;

				for($i = 1;$i < $allrows;$i++){
					mysqli_data_seek($query,$i);
					
					//添加
					$query = mysqli_query($conn, $sql);
					//
					$row = mysqli_fetch_assoc($query);

					if($row["TrainNum"] != $sdata["TrainNum"]){
						//new train

						TrainHead($sdata,$enddata);

						$sdata = $row;
						
						TrainDetailList($query,$sposi,$i);
						
						$sposi = $i;
						
					}
					else
						$enddata = $row;
					
				}

				//last one
				TrainHead($sdata,$enddata);

				TrainDetailList($query,$sposi,$allrows);


			}

			break;
		case "train":
			$train = $_GET["trainnum"];
			
			$sql = "SELECT * FROM through T1,train WHERE T1.TrainNum = train.TrainNum AND T1.TrainNum ='".$train."' ORDER BY T1.Order";

			//查询
			//# $query = mysql_query($sql)  or die('excute error:'.mysql_error());
			$query = mysqli_query($conn, $sql) or die('excute error:' . mysqli_error());


			//处理数据，输出列表
			//# $allrows = mysql_num_rows($query);
			$allrows = mysqli_num_rows($query);
			

			if($allrows > 0){
				//# $sdata = mysql_fetch_assoc($query);
				$sdata = mysqli_fetch_assoc($query);
				$sposi = 0;

				for($i = 1;$i < $allrows;$i++){
					//# mysql_data_seek($query,$i);
					mysqli_data_seek($query, $i);
					
					//# $row = mysql_fetch_assoc($query);
					$row = mysqli_fetch_assoc($query);

					if($row["TrainNum"] != $sdata["TrainNum"]){
						//new train

						TrainHead($sdata,$enddata);

						$sdata = $row;
						
						TrainDetailList($query,$sposi,$i);
						
						$sposi = $i;
						
					}
					else
						$enddata = $row;
					
				}

				//last one
				TrainHead($sdata,$enddata);

				TrainDetailList($query,$sposi,$allrows);


			}

			break;
		case "login":
			$username = $_GET["username"];
			$password = $_GET["password"];

			$sql = "SELECT * FROM user WHERE username='".$username."' AND password='".$password."'";
			
			//查询
			//# $query = mysql_query($sql)  or die('excute error:'.mysql_error());
			$query = mysqli_query($conn, $sql) or die('excute error:' . mysqli_error());
			
			
			//处理数据，输出列表
			////# if(mysql_num_rows($query)>0){
			if($temp = mysqli_num_rows($query)>0){
				//# $data = mysql_fetch_assoc($query);
				$data = mysqli_fetch_assoc($query);
				 echo "<div id='nowUserInfo'  username='".$data["username"]."' type='".$data["type"]."'  truename='".$data["truename"]."'  idnumber='".$data["idnumber"]."'  UID='".$data["UID"]."'></div>";
			}
			else
			{
				echo "<div id='nowUserInfo' UID=''>用户名或密码错误!</div>";
			}
			break;
		case "reg":
		case "buy":
			$userid = $_GET["userid"];
			$train = $_GET["train"];
			$type = $_GET["type"];
			$startstation = $_GET["ss"];
			$arrivestation = $_GET["as"];
			$starttime = $_GET["st"];
			$arrivetime = $_GET["at"];
			$mile = $_GET["mile"];
			$price = $_GET["price"];
			$num = $_GET["num"];
			$date = $_GET["date"];

			echo $train."<br>";

			$sql = "SELECT * FROM train WHERE TrainNum = '".$train."'";
			//# $query = mysql_query($sql)  or die('excute error:'.mysql_error());
			$query = mysqli_query($conn, $sql) or die('execute error:' . mysqli_error());
			
			//# $row = mysql_fetch_assoc($query);
			$row = mysqli_fetch_assoc($query);
			$cars = $row["Cars"];
			$carry = $row["Carry"];

			$sql = "SELECT * FROM ticket WHERE TrainNum = '".$train."' AND Date = '".$date."' ORDER BY Car,Position";

			$query = mysqli_query($conn, $sql)  or die('excute error:'.mysqli_error());
			if(mysqli_num_rows($query) == 0){
				$car=1;
				$position=1;
			}
			else
			{
				mysqli_data_seek($query,mysqli_num_rows($query)-1);
				$row = mysqli_fetch_assoc($query);

				$car = $row["Car"];
				$position = $row["Position"] +1;
			}

			for($i = 0;$i<$num;$i++){
				if($position > $carry){
					$position = 1;
					$car++;
				}

				if($car > $cars){
					echo "余票不足";
					break;
				}
				else
				{
					$sql = "INSERT INTO ticket (TrainNum,UID,Type,StartStation,ArriStation,StartTime,ArriTime,Date,Price,Mile,Car,Position) VALUES ('".$train."','".$userid."','".$type."','".$startstation."','".$arrivestation."','".$starttime."','".$arrivetime."','".$date."','".$price."','".$mile."','".$car."','".$position."')";

					mysqli_query($conn, $sql)  or die('excute error:'.mysqli_error());
				}


				$position++;
			}

			echo "购票成功";

			break;
		case "ticket":
			$userid = $_GET["userid"];

			$sql = "SELECT * FROM ticket WHERE UID = '".$userid."' ORDER BY Date DESC";

			$query = mysqli_query($conn, $sql)  or die('excute error:'.mysqli_error());


			UserTicketList($query);

			break;
		case "user":
			$userid = $_GET["userid"];

			$sql = "SELECT * FROM user WHERE UID = '".$userid."'";

			$query = mysqli_query($conn, $sql)  or die('excute error:'.mysqli_error());


			UserInformation($query);


			break;
		case "add":
			$object = $_GET["object"];

			if($object == "user"){
				
				$username = $_GET["username"];
				$password = $_GET["password"];

				$truename = $_GET["truename"];
				$idnumber = $_GET["idnumber"];

				$sql = "SELECT * FROM user WHERE username='".$username."'";
				
				//查询
				$query = mysqli_query($conn, $sql)  or die('excute error:'.mysqli_error());


				//处理数据，输出列表
				if(mysqli_num_rows($query)>0){
					echo "<div id='nowRegInfo' UID=''>该用户名已被注册</div>";
				}
				else
				{
					$sql = "INSERT INTO user (username,password,truename,idnumber) values ('".$username."','".$password."','".$truename."','".$idnumber."')";

					mysqli_query($conn, $sql)  or die('excute error:'.mysqli_error());

					//echo "<div id='nowRegInfo'  username='".$username."' type='0'  truename='".$truename."'  idnumber='".$idnumber."'  UID='".$data["UID"]."'></div>";
					echo "<div id='nowRegInfo' UID=''>注册成功</div>";
				}

				break;

			}

			if($object == "train"){
			}

			if($object == "through"){
			}

			if($object == "city"){
			}

			if($object == "station"){
			}
			break;
		case "del":
			$object = $_GET["object"];
			if($object == "ticket"){
				$tid = $_GET["tid"];
				$sql = "DELETE FROM ticket WHERE TID='".$tid."'";
				mysqli_query($conn, $sql)  or die('excute error:'.mysqli_error());
				echo "已删除";
			}

			if($object == "user"){
				$uid = $_GET["uid"];
				$sql = "DELETE FROM user WHERE UID='".$uid."'";
				mysqli_query($conn, $sql)  or die('excute error:'.mysqli_error());

			}

			if($object == "train"){
				$train = $_GET["train"];
				$sql = "DELETE FROM train WHERE TrainNum='".$train."'";
				mysqli_query($conn, $sql)  or die('excute error:'.mysqli_error());
			}

			if($object == "through"){
			}

			if($object == "station"){
				$station = $_GET["station"];
				$sql = "DELETE FROM station WHERE ='".$station."'";
				mysqli_query($conn, $sql)  or die('excute error:'.mysqli_error());
			}

			break;
		default:
	}
	//数据库操作


	
	


	//关闭数据库连接
	mysqli_close($conn);


	//require("footer.htm");


?>



