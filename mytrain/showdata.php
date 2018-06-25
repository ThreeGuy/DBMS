<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<?php
	//Program at 2018.6
	//显示列车信息头部
	function TrainHead($sdata,$edata){
		

		$lastmin = (strtotime($edata["AllTime"])-strtotime($sdata["AllTime"]))/60;
		$lasthour = (int)($lastmin / 60);
		$lastmin %= 60;
		$lasttime = $lasthour."小时".$lastmin."分钟";

?>

			<DIV class=item>
			  <UL id=list_<?=$sdata["TrainNum"]?> class=info train=<?=$sdata["TrainNum"]?>>
				<LI class=c1></LI>
				<LI class=c2>
				  <DIV class=NO>
					<A onclick="" train="<?=$sdata["TrainNum"]?>"><?=$sdata["TrainNum"]?></A>
				  </DIV>
				</LI>
				<LI class=c2>
				  <DIV><?=$sdata["Type"]?></DIV>
				</LI>
				<LI class=c3>
				  <DIV><?=$sdata["Station"]?>-<?=$edata["Station"]?></DIV>
				</LI>
				<LI class=c4>
				  <DIV class=t1><?=$sdata["StartTime"]?></DIV>
                </LI>
                <LI class=c4>
				  <DIV class=t2><?=$edata["ArriveTime"]?></DIV>
				</LI>
				<LI class=c5>
				  <?=$lasttime?>
				</LI>
				<LI class=c6>
					<?=($edata["AllMile"] - $sdata["AllMile"])?>公里
				</LI>
				<LI class=c7>
				  <SPAN class=pr>￥<?=($edata["AllPrice"] - $sdata["AllPrice"])?></SPAN>
				</LI>
				<LI class=c8>
				  <DIV><A class="buyTicketInfo" train="<?=$sdata["TrainNum"]?>" traintype="<?=$sdata["Type"]?>" startstation="<?=$sdata["Station"]?>" arrivestation="<?=$edata["Station"]?>" starttime="<?=$sdata["StartTime"]?>" arrivetime="<?=$edata["ArriveTime"]?>" price="<?=($edata["AllPrice"] - $sdata["AllPrice"])?>" mile="<?=($edata["AllMile"] - $sdata["AllMile"])?>">购买</A></DIV>
				</LI>
			  </UL>
			  
			<DIV style="DISPLAY: none" id=detail_<?=$sdata["TrainNum"]?> class=" orario">
				<DIV class=ic></DIV>
				<DIV class=t1></DIV>
				<DIV class=t2></DIV>
				<DIV class=t3></DIV>
				<DIV class=hd></DIV>
				<TABLE class=timetable cellSpacing=0 cellPadding=0>
				  <TBODY>
					<TR>
					  <TH class=c1 valgin="top">站次</TH>
					  <TH class=c2 valgin="top">站名</TH>
					  <TH class=c4 valgin="top">到达时间</TH>
					  <TH class=c5 valgin="top">开车时间</TH>
					  <TH class=c6 valgin="top">运行时间</TH>
					  <TH class=c7 valgin="top">里程</TH>
					  <TH class=c8 valgin="top">票价</TH>
					</TR>

<?php
	}


	//显示列车详细线路
	function TrainDetailList($data,$st,$ed){

		mysqli_data_seek($data,$st);
		for($j = $st; $j < $ed;$j++){
			$row1 = mysqli_fetch_assoc($data);

			if($j == $st){ //start station
				$startdata = $row1;
			}

			$lastmin = (strtotime($row1["AllTime"])-strtotime($startdata["AllTime"]))/60;
			$lasthour = (int)($lastmin / 60);
			$lastmin %= 60;
			$lasttime = $lasthour."小时".$lastmin."分钟";


			?>

				

					<TR class=hl>
					  <TD class=c1><?=$row1["Order"]?></TD>
					  <TD class=c2><A href="" target=_blank><?=$row1["Station"]?></A></TD>
					  <TD class=c4><?=$row1["ArriveTime"]?></TD>
					  <TD class=c5><?=$row1["StartTime"]?></TD>
					  <TD class=c6><?=$lasttime?></TD>
					  <TD class=c7><?=($row1["AllMile"] - $startdata["AllMile"])?>公里</TD>
					  <TD class=c8><?=($row1["AllPrice"] - $startdata["AllPrice"])?></TD>
					</TR>
		  


			<?php
			
		}
	
	?>

					</TBODY>
				</TABLE>
				<DIV class=ft>
				  <TABLE cellSpacing=0 cellPadding=0>
					<TBODY>
					  <TR>
						<TD vAlign=top width=150 align="center"><B>全部里程:</B></TD>
						<TD vAlign=top width=150 align="center"><?=($row1["AllMile"] - $startdata["AllMile"])?>公里</TD>
						<TD vAlign=top width=150 align="center"><B>全程时间:</B></TD>
						<TD vAlign=top width=150 align="center"><?=$lasttime?></TD>
						<TD vAlign=top width=150 align="center"><B>全程票价:</B></TD>
						<TD vAlign=top width=150 align="center"><?=($row1["AllPrice"] - $startdata["AllPrice"])?>元</TD>
					  </TR>
					</TBODY>
				  </TABLE>
				</DIV>
				<DIV class=b3></DIV>
				<DIV class=b2></DIV>
				<DIV class=b1></DIV>
			  </DIV>
			</DIV>

	
	<?php
	}

	function UserTicketList($query){
		//处理数据，输出列表
			$allrows = mysqli_num_rows($query);
			for($i=0;$i<$allrows;$i++){
				$data = mysqli_fetch_assoc($query);
	?>
			<DIV class=item>
			  <UL id=list_<?=$data["TrainNum"]?> class=info train=<?=$data["TrainNum"]?>>
				<LI class=c1></LI>
				<LI class=c2>
				  <DIV class=NO>
					<A onclick="" train="<?=$data["TrainNum"]?>"><?=$data["TrainNum"]?></A>
				  </DIV>
				</LI>
				<LI class=c2>
				  <DIV><?=$data["Type"]?></DIV>
				</LI>
				<LI class=c3>
				  <DIV><?=$data["StartStation"]?>-<?=$data["ArriStation"]?></DIV>
				</LI>
				<LI class=c4>
				  <DIV class=t1><?=$data["StartTime"]?></DIV>
                </LI>
                <LI class=c4>
				  <DIV class=t2><?=$data["ArriTime"]?></DIV>
				</LI>
				<LI class=c5>
				  <DIV class=t2><?=$data["Date"]?></DIV>
				</LI>
				<LI class=c6>
					<DIV><?=$data["Mile"]?>公里</DIV>
				</LI>
				<LI class=c8>
				  <?=$data["Car"]?>车  <?=$data["Position"]?>号
				</LI>
				<LI class=c8>
				   <?=$data["Price"]?>
				</LI>
				<LI class=c8>
				   <A class="delTicketInfo" tid="<?=$data["TID"]?>">删除</A>
				</LI>
			  </UL>
			 </DIV>
	<?php			
			}
	}


	function UserInformation($query){
		$data = mysqli_fetch_assoc($query);

	?>

	<?php
	}

?>