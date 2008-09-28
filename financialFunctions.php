<?php
	include("functions/balanceRemaining.php");
	//Calls nothing, Called by pagelayout
	include("functions/currentAmount.php");
	//function	currentAmount($accountNumber) 
	//Takes account number and returns start amount for account
	//plus transactions to account  minus transactions from account
	//Calls to sumMonth
	//Called by pagelayout
	include("functions/dropDowns.php");
	//Calls to Selected, Called By edittrans, newTR
	include("functions/editItem.php");
	//Calls to monthdropdown, daydropdown, yeardropdown,
	//Calls to descriptionbox, accountdropdown, amountbox
	//Called by newTR, pagelayout
	include("functions/smallFunctions.php");
	//Calls nothing, Called by pagelayout
	include("functions/newest.php");
	//Calls nothing, Called by newTR, pagelayout
	include("functions/newTR.php");
	//Calls to newestTransaction, edittrans, daydropdown, submitTransaction, reloadPHP
	//Called by pagelayout
	include("functions/billsDue.php");
	//
	//
	//Called by pagelayout
	include("functions/pagelayout.php");
	//Calls to balanceRemaining, currentAmount, negativeRed
	//Calls to newTR, newestTransaction, submitTransaction
	//Calls to reloadPHP, edittrans, isZero, billsDue
	//Called by index
	include("functions/paid.php");
	include("functions/setupAcc.php");
	//Calls nothing
	//Called by index
	include("functions/submitItem.php");
	//Called by newTR, pagelayout
	include("functions/sumMonth.php");
	//Called by currentAmount


?>


