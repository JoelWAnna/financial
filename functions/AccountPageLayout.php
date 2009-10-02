<?php function AccountPageLayout($page,&$accounttype,&$accounts){
//Main Page
	$months = array(0,Jan,Feb,Mar,Apr,
					May,June,July,Aug,
					Sep,Oct,Nov,Dec);
	$tdform = "\n    <td";
	$tdformat2 = "</td>".$tdform;
	$tdformat = $tdformat2.">";
	$w = " width=";
/////////////PAGE  > 0
	$new = newest('trans');
	$X = "X";
	$X .= $new;
	if (isset($_POST[$X])){
		if(submitItem('trans',$new)){
			reloadPHP();
			unset($_POST[$X]);
		}
	}	
	echo "<a href=\"" . $_SERVER['PHP_SELF'] . "?page=0\">Back to main</a>";
	echo "<Br><B>".$accounts[$page]."</B>";
	echo "<table bordercolor=\"000\" border=2>\n  ";
	echo "<tr align=center>\n    <td width=165 colSpan=\"3\">date</td>"
		. $tdform.$w."142>description</td>"
		. $tdform.$w."145>from account</td>"
		. $tdform.$w."143>to account</td>"
		. $tdform.$w."50>amount</td>"
		. $tdform.$w."55>balance</td>"
		. "<form action=\"" . $_SERVER['PHP_SELF']
		. "?page=". $page ."\" method=\"post\">"
		. $tdform."><input type=\"submit\" "
		. "name=\"".$new."\" value=\""
		. "Start new transaction"
		. "\"></td></form>\n  </tr>";
	if($new > 0){
		if (isset($_POST[$new])){
			editItem('trans',$page,$accounts,$new,true);
		}
	}

	$CurrentAm= currentAmount($page);

	$queryAcc = " SELECT * FROM `".PREFIX.TRANSACTIONS."` WHERE `From Account` ="
			. $page." OR `To Account` =".$page." ORDER BY `".PREFIX.TRANSACTIONS."`.`year` DESC, `"
			.PREFIX.TRANSACTIONS."`.`month` DESC, `".PREFIX.TRANSACTIONS
			."`.`day` DESC";
 
	$resultAcc = mysql_query($queryAcc)
		or die('Error in query: $queryAcc.' . mysql_error());
	
	if (mysql_num_rows($resultAcc) > 0){
		while($rowdata = mysql_fetch_assoc($resultAcc)){

			
			$X = "X";
			$X .= $rowdata['number'];
			if (isset($_POST[$X])){
				if(submitItem('trans',$rowdata['number'])){
					reloadPHP();
				}
			unset($_POST[$X]);
			} 
			
			echo "\n  <tr align=center>" . $tdform . $w. "55>"
				. $months[(int)$rowdata['month']]. $tdformat2. $w. "50>"
				. $rowdata['day'] . $tdformat2. $w. "55>"
				. $rowdata['year'] . $tdformat
				. $rowdata['description'] . $tdformat
				. $accounts[$rowdata['from account']] . $tdformat
				. $accounts[$rowdata['to account']]	. $tdformat;
			echo "<div";
			if($rowdata['from account']==$page){
				echo " id=\"negative\">-";
			}else{echo ">";}
			echo $rowdata['amount'];
			echo "</div>";
			
			echo $tdformat;
			
			if($rowdata['from account']==$page){
				echo "<div";
				if($CurrentAm<0){echo " id=\"negative\"";}
				echo ">";
				printf("%.2f",$CurrentAm);
				echo "</div>";
				$CurrentAm += $rowdata['amount'];
			}
			
			else{
				$CurrentAm =round($CurrentAm,2);
				echo "<div";
				if($CurrentAm<0){echo " id=\"negative\"";}
				echo ">";
				printf("%.2f",$CurrentAm);
				echo "</div>";
				$CurrentAm	-= $rowdata['amount'];
			}
			
			echo "</td>\n    ";
			echo "<form action=\"" . $_SERVER['PHP_SELF']. "?page=". $page 
				. "\" method=\"post\">".  $tdform. "><input type=\"submit\" name=\""
				. $rowdata['number']."\" value=\"". "Edit transaction " . $rowdata['number']
				. " \">" . "</td>\n    </form>";
			echo "\n  </tr>";
			
			if (isset($_POST[$rowdata['number']])){
				editItem('trans',$page,$accounts,$rowdata['number'],false,false,
						(int)$rowdata['month'],$rowdata['day'],$rowdata['year'],
						$rowdata['description'],$rowdata['from account'],
						$rowdata['to account'],$rowdata['amount']);
			}
		}
	}else{echo '<b>Error No transactions found</b>';}
	echo "\n</table>";
		mysql_free_result($resultAcc);
	}
?>