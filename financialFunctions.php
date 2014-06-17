<?php
	include("functions/Authentication.php");
	include("functions/balanceRemaining.php");
	//Calls nothing, Called by pagelayout
	include("functions/dropDowns.php");
	//Calls to Selected, Called By edittrans, newTR
	include("functions/editItem.php");
	//Calls to monthdropdown, daydropdown, yeardropdown,
	//Calls to descriptionbox, accountdropdown, amountbox
	//Called by newTR, pagelayout
	include("functions/smallFunctions.php");
	//Calls nothing, Called by newTR, pagelayout
	include("functions/newTR.php");
	//Calls to newestTransaction, edittrans, daydropdown, submitTransaction, reloadPHP
	//Called by pagelayout
	include("functions/billsDue.php");
	//Called by pagelayout
	include("functions/MainPageLayout.php");
	include("functions/AccountPageLayout.php");
	//Calls to balanceRemaining, currentAmount,
	//Calls to newTR, newestTransaction, submitTransaction
	//Calls to reloadPHP, edittrans, isZero, billsDue
	//Called by index
	include("functions/setupAcc.php");
	//Calls nothing
	//Called by index
	include("functions/submitAcc.php");
//
	include("functions/editAcc.php");
//
	include("functions/submitItem.php");
	//Called by newTR, pagelayout
	include("functions/sumMonth.php");
	//Called by currentAmount
	include("functions/totals.php");
	//Called by currentAmount
	include("functions/JavaFunctions.php");
	include("functions/CleanupFunctions.php");
?>
