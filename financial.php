<html>
<head><title>test</title>
<?php
	include("finFunc.php");
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
	//$debug = true;	//$debug2 =true;
	//$index=0;
	$page = $_GET['page'];
	$months = array(0,Jan,Feb,Mar,Apr,
					May,June,July,Aug,
					Sep,Oct,Nov,Dec);
	$tdform = "\n    <td";
	$tdformat2 = "</td>".$tdform;
	$tdformat = $tdformat2.">";
	$w = " width=";
	$accounttype;
	$accounts;
	
	
	$connection = mysql_connect('localhost','guest')
		or die('Unable to connect!');
	setupAcc();
?>

<?php //Main Page
	if($page==0){
	$count=4;
	$i=0;
	$index=0;
	echo "<table>\n";
	while(/*$accounttype[$index]*/$count--){
		echo "  <tr>" . $tdform . "><u><B>" . $accounttype[$index]
			. " Accounts</B></u></td>" . "\n  </tr>";
		$queryAccount = " SELECT number FROM `accounts` "
				. "WHERE `Type` = CONVERT( _utf8 '"
				. $accounttype[$index]."' "
				. "USING latin1 ) COLLATE latin1_swedish_ci LIMIT 0 , 30";
		$resultAccount = mysql_query($queryAccount)
			or die('Error in query: line 66.' . mysql_error());
		
		if (mysql_num_rows($resultAccount) > 0){
			while($rowAcc = mysql_fetch_row($resultAccount)){
				$j=$rowAcc[0];
				echo "\n  <tr>"
					. $tdform .">"
					."<lis><a href =\"financial.php?page="
					. $j . "\"><span>"
					. $accounts[$j] . "</span></a></lis>"
					."</td>";
					$CurrentFunds[$j] = currentAmount($j);
				echo $tdform . " width=75px align=right>";
				negativeRed($CurrentFunds[$j]);
				echo	$CurrentFunds[$j]. $tdform .">\n  </tr>\n";		
			}
		}else{
			echo '<b>Error Line 97</b>';
		}
		mysql_free_result($result);
		$index++;
	}
	echo"</table>";
	}
?>






<?php 
	if($page > 0){
	$new = newestTransaction();
	echo "<a href=financial.php?page=0>Back to main</a>";
	echo "<B>".$accounts[$page]."</B>";
	echo "<table bordercolor=\"000\" border=2>\n  ";
	echo "<tr align=center>\n    <td width=165 colSpan=\"3\">date</td>"
		. $tdform.$w."142>description</td>"
		. $tdform.$w."145>from account</td>"
		. $tdform.$w."143>to account</td>"
		. $tdform.$w."50>amount</td>"
		. $tdform.$w."55>balance</td>"
		. "<form action=\"" . $_SERVER['PHP_SELF']
		. "?page=". $page . "\" method=\"post\">"
		. $tdform."><input type=\"submit\""
		. "name=\"".$new."\" value=\""
		. "Start new transaction"
		. "\"></td></form>\n  </tr>";
	if($new > 0){
		
		//edittrans($new);
	
	if (isset($_POST[$new])){
		$newtransa =true;
		echo "\n    <tr><form action=\"" . $_SERVER['PHP_SELF']
			. "?page=" . $page . "\" method=\"post\">";
		edittrans($new);
		echo "</form></tr>"; 
		$newtransa =false;
	}
		
		
		
		
		
	}
	$CurrentAm= currentAmount();
	
	 $queryAcc = " SELECT * FROM `transactions` WHERE `From Account` ="
				. $page." OR `To Account` =".$page." ORDER BY `transactions`.`number` DESC";// LIMIT 0 , 30 ";
	//LOOK@@ 
/* 	$reslts = mysql_query($queryAcc)
		or die('Error in query: $queryAcc.' . mysql_error());
	if (mysql_num_rows($reslts) > 0){
		$rowss = mysql_fetch_assoc($reslts);
		//$CurrentAm -=$rowss['amount']; 
	}	 */
	$resultAcc = mysql_query($queryAcc)
		or die('Error in query: $queryAcc.' . mysql_error());
	
		if (mysql_num_rows($resultAcc) > 0){
		while($rowdata = mysql_fetch_assoc($resultAcc)){
			
			
			echo "\n  <tr align=center>" . $tdform . $w. "55>"
				. $months[(int)$rowdata['month']]. $tdformat2. $w. "50>"
				. $rowdata['day'] . $tdformat2. $w. "55>"
				. $rowdata['year'] . $tdformat
				. $rowdata['description'] . $tdformat
				. $accounts[$rowdata['from account']] . $tdformat
				. $accounts[$rowdata['to account']]	. $tdformat;
			
			if($rowdata['from account']==$page){
				negativeRed(-1);
				echo "-";
			}
			echo $rowdata['amount'];
			
			echo $tdformat;
			
			if($rowdata['from account']==$page){
				negativeRed($CurrentAm);
				echo $CurrentAm;
				$CurrentAm += $rowdata['amount'];
				if($debug){
					echo "</td><td>" . $CurrentAm 
						 . "</td><td>". -$rowdata['amount'];}
			}
			
			else{
				if(isZero($CurrentAm)){
					echo 0;
				}
				else{
					negativeRed($CurrentAm);
					echo $CurrentAm;
				}
				$CurrentAm	-= $rowdata['amount'];
				if($debug){
					echo "</td><td>" . $CurrentAm
						. "</td><td>". $rowdata['amount'];
				}
			}
			
			echo "</td>\n    ";
			echo "<form action=\"" . $_SERVER['PHP_SELF']. "?page=". $page 
				. "\" method=\"post\">".  $tdform. "><input type=\"submit\" name=\""
				. $rowdata['number']."\" value=\"". "Edit transaction " . $rowdata['number']
				. " \">" . "</td>\n    </form>";
			echo "\n  </tr>";
			
			/* if (isset($_POST[$rowdata['number']])){
				//echo $_POST[$rowdata['number']];
				echo "\n    <tr><form action=\"" . $_SERVER['PHP_SELF']. "?page="
					. $page . "\" method=\"post\">"; */
				
				edittrans($rowdata['number'],(int)$rowdata['month'],
						$rowdata['day'],$rowdata['year'],
						$rowdata['description'],$rowdata['from account'],
						$rowdata['to account'],$rowdata['amount'],'poop');
						
			/* 	echo "</form></tr>";
			} */
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







<?php
edittrans();
edittrans(55555,1,2,2009,sdfsadfsadf);
?>

</td></tr></table>


</form>




</body>
</html>