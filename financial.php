<html>
<head><title>test</title>
<?php
	error_reporting(0);
	extract($_POST);extract($_SERVER);
	$host = "127.0.0.1";$local = true;$timeout = "1";
	if ($REMOTE_ADDR) {
		if ($REMOTE_ADDR != $host) {
			$local = false;
		}
	}
?>

<?php 	if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS']))
		{$uri2 = 'https://';}
		else {$uri2 = 'http://';}
	$uri2 .= $_SERVER['HTTP_HOST'];
	$fti = 'ftp://' . $_SERVER['HTTP_HOST'];
	$uri = $uri2 . '/';
	$app = $uri . 'webapps/';
?>
	
<!--
<link href="<?php //echo $app; ?>support/styles.css" rel="stylesheet" type="text/css">*/
-->	
</head>
<body>

<?php //Initialize
	//$debug = true;
	$index=0;
	$months = array(0,Jan,Feb,Mar,Apr,May,June,July,Aug,Sep,Oct,Nov,Dec);
	$page = $_GET['page'];
	$connection = mysql_connect('localhost','guest')
		or die('Unable to connect!');
	$databaseFin='financial';
	mysql_select_db($databaseFin)
		or die('Unable to select database! $databaseFin');
	
	
	$querytype ="SELECT DISTINCT `Type` FROM `accounts` LIMIT 0 , 30";
	$queryname ="SELECT number, name, type FROM `accounts`";
	
	$typeresult = mysql_query($querytype)
		or die('Error in query: $querytype.' . mysql_error());
	$resultname = mysql_query($queryname)
		or die('Error in query: $queryname.' . mysql_error());
	
	if (mysql_num_rows($typeresult) > 0){
		while($row = mysql_fetch_row($typeresult)){		
			$accounttype[$index++]=$row[0];
		}
	}else{
		echo '<b>Error Line 53</b>';}
	if (mysql_num_rows($resultname) > 0){
		while($row = mysql_fetch_row($resultname)){		
			$accounts[$row[0]]= $row[1];
		}
	}else{
		echo '<b>Error Line 59</b>';
	}
	mysql_free_result($resultname);
	mysql_free_result($typeresult);
	$index=0;
?>

<?php //Main Page
	if($page==0){
	$count=4;
	$i=0;
	echo "<table>\n";
	while(/*$accounttype[$index]*/$count--){
		echo "  <tr>\n    <td><u><B>".$accounttype[$index]." Accounts</B></u>\n    </td>\n  </tr>";
		$query = " SELECT number FROM `accounts` WHERE `Type` = CONVERT( _utf8 '"
				. $accounttype[$index]."' "
				. "USING latin1 ) COLLATE latin1_swedish_ci LIMIT 0 , 30";
		$querynum ="SELECT current FROM accounts";
		$result = mysql_query($query)
			or die('Error in query: $query.' . mysql_error());
		$resultnum = mysql_query($querynum)
			or die('Error in query: $querynum.' . mysql_error());
		if (mysql_num_rows($resultnum) > 0){
			while($rownumdata = mysql_fetch_row($resultnum)){
				$CurrentFunds[++$i]= $rownumdata[0];
			}
		}else{
			echo '<b>Error No start found</b>';
		}
		mysql_free_result($resultnum);
		if (mysql_num_rows($result) > 0){
			while($row = mysql_fetch_row($result)){	
				echo "\n  <tr>\n    <td><lis><a href =\"financial.php?page=".$row[0]."\"><span>"
					. $accounts[$row[0]] . "</span></a></lis>"."\n    </td>";

				$summinus = 'SELECT SUM( `Amount` )'
				        . ' FROM `transactions`'
				        . ' WHERE `From Account` ='.$row[0];
				$sumplus = 'SELECT SUM( `Amount` )'
				        . ' FROM `transactions`'
				        . ' WHERE `To Account` ='.$row[0];
				$resultminus = mysql_query($summinus)
					or die('Error in query: $summinus.' . mysql_error());
				$resultplus = mysql_query($sumplus)
					or die('Error in query: $sumplus.' . mysql_error());

				if (mysql_num_rows($resultplus) > 0){
					while($rowplus = mysql_fetch_row($resultplus)){		
						$CurrentFunds[$row[0]] += $rowplus[0];
					}
				}else{
					echo 'error line 110';
				}
				if (mysql_num_rows($resultminus) > 0){
					while($rowminus = mysql_fetch_row($resultminus)){		
						$CurrentFunds[$row[0]] -= $rowminus[0];
					}
				}else{
					echo 'error line 117';
				}
				mysql_free_result($resultplus);
				mysql_free_result($resultminus);
				echo 	"\n    <td width=75px align=right>";
				if($CurrentFunds[$row[0]] < 0){
					echo "<font color = red>";
				}
				echo	$CurrentFunds[$row[0]]."\n    </td>\n  </tr>\n";		
			}
		}else{
			echo '<b>Error Line 128</b>';
		}
		mysql_free_result($result);
		$index++;
	}
	echo"</table>";
	}
?>








<?php 
	if($page >0){
	$querynum = "SELECT current FROM accounts Where number =" . $page;
	$resultnum = mysql_query($querynum)
		or die('Error in query: $querynum.' . mysql_error());
	if (mysql_num_rows($resultnum) > 0){
		while($rownumdata = mysql_fetch_row($resultnum)){
			$CurrentAm = $rownumdata[0];
		}
	}else{
		echo '<b>Error No start found</b>';
	}
	mysql_free_result($resultnum);
	
	
	
	echo "<a href=financial.php?page=0>Back to main</a>";
	echo "<B>".$accounts[$page]."</B>";
	echo "<table bordercolor=\"000\" border=2>\n  ";
	echo "<tr align=center>\n    <td width=165 colSpan=\"3\">date</td>"
		. "\n    <td width=142>description</td>"
		. "\n    <td width=145>from account</td>"
		. "\n    <td width=143>to account</td>"
		. "\n    <td width=50>amount</td>"
		. "\n    <td  width=55>balance</td>"
		. "\n    <th><input type=\"submit\""
		. "name=\"submit\" value=\""
		. "Start new transaction"
		. "\"></th>\n  </tr>";
	
	$summinus = 'SELECT SUM( `Amount` )'
			. ' FROM `transactions`'
			. ' WHERE `From Account` ='.$page;
	$sumplus = 'SELECT SUM( `Amount` )'
			. ' FROM `transactions`'
			. ' WHERE `To Account` ='.$page;
	$resultminus = mysql_query($summinus)
		or die('Error in query: $summinus.' . mysql_error());
	$resultplus = mysql_query($sumplus)
		or die('Error in query: $sumplus.' . mysql_error());

	if (mysql_num_rows($resultplus) > 0){
		while($rowplus = mysql_fetch_row($resultplus)){		
			$CurrentAm += $rowplus[0];
		}
	}else{echo 'error line 117';}
	if (mysql_num_rows($resultminus) > 0){
		while($rowminus = mysql_fetch_row($resultminus)){		
			$CurrentAm -= $rowminus[0];
		}
	}else{echo 'error line 122';}
	mysql_free_result($resultplus);
	mysql_free_result($resultminus);
	
	
	
	$queryAcc =" SELECT * FROM `transactions` WHERE `From Account` =".$page." OR `To Account` =".$page." ORDER BY `transactions`.`number` DESC";// LIMIT 0 , 30 ";
	 
	$reslts = mysql_query($queryAcc)
		or die('Error in query: $queryAcc.' . mysql_error());
	if (mysql_num_rows($reslts) > 0){
		$rowss = mysql_fetch_assoc($reslts);
		//$CurrentAm -=$rowss['amount'];
	}	
	
		
		
	$resultAcc = mysql_query($queryAcc)
		or die('Error in query: $queryAcc.' . mysql_error());
	if (mysql_num_rows($resultAcc) > 0){
		while($rowdata = mysql_fetch_assoc($resultAcc)){		
			echo "\n  <tr align=center>\n    <td width=55>";
			echo "&nbsp ";
			echo $months[((int)$rowdata['month'])];
			echo "\n    </td>\n    <td width=50>";
			echo $rowdata['day'];
			echo "\n    </td>\n    <td width=55>";
			echo $rowdata['year'];
			echo "&nbsp";
			echo "\n    </td>\n    <td>";
			echo $rowdata['description'];
			echo "\n    </td>\n    <td>";
			//echo $rowdata['3'];
			
			echo $accounts[$rowdata['from account']];
			//echo $rowdata['4'];//echo $rowdata['from account'];
			echo "\n    </td>\n    <td>";
			echo $accounts[$rowdata['to account']];
			//echo $rowdata['5'];//echo $rowdata['to account'];
			echo "\n    </td>\n    <td>";
			if($rowdata['from account']==$page){
			echo "<font color = red>";
			echo -$rowdata['amount'];
			}else{echo $rowdata['amount'];}
			echo "\n    </td>\n    <td>";
			if($rowdata['from account']==$page){
					if($CurrentAm < -.01){
				echo "<font color = red>";}
				echo $CurrentAm;
				$CurrentAm += $rowdata['amount'];
				if($debug){echo "</td><td>".$CurrentAm . "</td><td>". -$rowdata['amount'];}
			}else{
				if($CurrentAm < .001 && $CurrentAm < .002){echo 0;}
				else{
				if($CurrentAm < 0){
				echo "<font color = red>";}
				echo $CurrentAm;}
				$CurrentAm	-= $rowdata['amount'];
				if($debug){echo "</td><td>".$CurrentAm . "</td><td>". $rowdata['amount'];}
			}
			echo "\n    <th><input type=\"submit\" name=\"submit\" value=\""
				. "Edit transaction " . $rowdata['number'] ." \">\n    </th>";
			echo "\n    </td>\n  </tr>";
			// echo "<tr><td>&nbsp</td></tr>";
			// echo $row['path'];
			// $accounttype[$index++]=$row[0];
		}
	}else{echo '<b>Error No transactions found</b>';}
	echo "\n</table>";
	mysql_free_result($resultAcc);
}
?>
<?php mysql_close($connection);
?>


<!--form action="" -->
<table bordercolor=\"000\" border=2><tr><td>
<?php
	$j= date("M");
	$months = array(0,Jan,Feb,Mar,Apr,May,June,July,Aug,Sep,Oct,Nov,Dec);
	echo "<select name=\"month\">\n";
	for($i=1;$i<13;$i++){
		echo "\t<option value=\"";
		if($i<10){ echo "0";}
		echo $i. "\"";
		if($months[$i] == $j){echo " selected=\"selected\"";}
		echo ">". $months[$i]."</option>\n";
	}
	echo  "</select>\n";

	$j= date("d");
	echo "<select name=\"day\">\n";
	$i=0;
	while(++$i <32){
		echo "\t<option value=\"".$i."\"";
		if($i==$j){echo " selected=\"selected\"";}
		echo ">" .$i."</option>\n";
	}
	echo "</select>\n";

	echo "<select name=\"year\">\n";
	for($i=-1;$i < 2;$i++){
		$j= date("Y");
		echo "\t<option value=\"".($i + $j)."\"";
		if($i==0){
			echo " selected=\"selected\" ";
		}
		echo ">" .($i + $j)."</option>\n";
	}
	echo "</select>\n";

	echo "<input type=\"text\" name=\"description\" maxlength=\"10\" value=\"\">\n";
	
	echo "<select name=\"to account\">\n";
	$i=1;
	while($accounts[$i]){
		echo "\t<option value=\"".$i."\">".$accounts[$i++]."</option>\n";
	}
	echo "</select>\n";

	echo "<select name=\"from account\">\n";
	$i=1;
	while($accounts[$i]){
		echo "\t<option value=\"".$i."\">".$accounts[$i++]."</option>\n";
	}
	echo "</select>\n";

	echo "<input type=\"number\" name=\"amount\""
		. " maxlength=\"10\" size=\"5\" value=\"\" showlength=\"4\">\n";
?>
</td></tr></table>


<!--/form -->




</body>
</html>