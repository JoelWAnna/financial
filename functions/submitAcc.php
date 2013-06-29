<?php function submitAcc($number,$new){

$NAME = "descriptionName".$number;
$TYPE = "Type".$number;
$TYPE2 = "2Type".$number;
$TYPE3 = "3Type".$number;
$IRATE = "amountIRate".$number;
$BUDGET = "amountBudget".$number;
$START = "amountstart".$number;


	$_POST[$IRATE]=(float)$_POST[$IRATE];
	$_POST[$BUDGET]=(float)$_POST[$BUDGET];
	$_POST[$START]=(float)$_POST[$START];
	
	if (!$_POST[$NAME]){
		Panic("You did not enter a name");
		return false;
	}
	if($new =='new'){
		if($_POST[$TYPE]){
		$type = $_POST[$TYPE];
		}else if($_POST[$TYPE2]){
			$type = $_POST[$TYPE2];
		}else if($_POST[$TYPE3]){
			$type = $_POST[$TYPE3];
		}else {	
		Panic("You did not enter a type");
		return false;
		}
	
	}else{
	if (!$_POST[$TYPE]){
		Panic("You did not enter a type");
		return false;
	}else{$type = $_POST[$TYPE];}
	}

	if($new == 'new'){
	$query ="Insert Into `".DATABASENAME
			."`.`".PREFIX.ACCOUNTS."` SET `"
			.PREFIX.ACCOUNTS."`.`number` ='"
			. $number . "', ";
	}else{
		$query = "UPDATE `" . DATABASENAME. "`.`" . PREFIX . ACCOUNTS. "` SET ";
	}
	$query .= "`Name` = '" . $_POST[$NAME]	. "', `Type` = '" . $type
		. "', `Interest Rate` = '" . $_POST[$IRATE]	. "', `Budget` = '" . $_POST[$BUDGET]
		. "', `start` = '" . $_POST[$START] ."'";
	if(!($new == 'new')){
		$query .= " WHERE `".PREFIX.ACCOUNTS."`.`number` =". $number ." LIMIT 1";
	}

	
	//mysql_close($connect);
	//$connect = mysql_connect(HOSTNAME, UPDATEUSER, UPDATEPASSWORD)
//		or die('Unable to connect!');
//	mysql_select_db(DATABASENAME)
		//or die('Unable to select database! DATABASENAME');
	$connection = ConnectToDB(UPDATEUSER, UPDATEPASSWORD);
	$stmt = $connection->prepare($query);
	$Rquery = $stmt->execute()
		or die("Error in query: $query." . mysql_error());
	//mysql_close($connect);
	//$connect = mysql_connect(HOSTNAME, USERNAME, PASSWORD)
//		or die('Unable to connect!');
	return true;
	
}?>