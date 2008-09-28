<?php
	include("functions/accountdropdown.php");
	//Calls to Selected, Called By edittrans
	include("functions/amountbox.php");
	//Calls nothing, Called by edittrans
	include("functions/balanceRemaining.php");
	//Calls nothing, Called by pagelayout
	include("functions/currentAmount.php");
	//function	currentAmount($accountNumber) 
	//Takes account number and returns start amount for account
	//plus transactions to account  minus transactions from account
	//Calls to sumMonth
	//Called by pagelayout
	include("functions/daydropdown.php");
	//Calls to Selected, Called By edittrans, newTR
	include("functions/descriptionbox.php");
	//Calls nothing, Called By edittrans
	include("functions/editBill.php");

	include("functions/edittrans.php");
	//Calls to monthdropdown, daydropdown, yeardropdown,
	//Calls to descriptionbox, accountdropdown, amountbox
	//Called by newTR, pagelayout
	include("functions/isZero.php");
	//Calls nothing, Called by pagelayout
	include("functions/monthdropdown.php");
	//Calls to Selected, Called by edittrans
	include("functions/negativeRed.php");
	//Calls nothing, Called by pagelayout
	include("functions/newestBill.php");
	include("functions/newestTransaction.php");
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
	include("functions/reloadPHP.php");
	//Calls nothing, Called by newTR, pagelayout
	include("functions/selected.php");
	//Calls nothing
	//Called by accountdropdown, daydropdown
	//Called by yeardropdown, monthdropdown
	include("functions/setupAcc.php");
	//Calls nothing
	//Called by index
	include("functions/submitBill.php");
	include("functions/submitTransaction.php");
	//Called by newTR, pagelayout
	include("functions/sumMonth.php");
	//Called by currentAmount
	include("functions/yeardropdown.php");
	//Calls to Selected, Called by edittrans

?>


