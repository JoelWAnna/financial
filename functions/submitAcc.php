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

	$UpdatedAccount = new Account();
	$UpdatedAccount->number = $number;
	$UpdatedAccount->name = $_POST[$NAME];
	$UpdatedAccount->type =  $type;
	$UpdatedAccount->interest = $_POST[$IRATE];
	$UpdatedAccount->budget = $_POST[$BUDGET];
	$UpdatedAccount->start = $_POST[$START];
	Queries::SubmitAccount($new, $UpdatedAccount);
	return true;
	
}?>