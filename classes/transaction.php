<?php
class Transaction
{
    function Transaction($mysqldata)
    {
        $this->number = $mysqldata['number'];
        $this->month = (int)$mysqldata['month'];
        $this->day = $mysqldata['day'];
        $this->year = $mysqldata['year'];
        $this->description = $mysqldata['description'];
        $this->from_Account_Number = $mysqldata['from account'];
        $this->to_Account_Number = $mysqldata['to account'];
        $this->amount = $mysqldata['amount'];
    }
    
    function fromAccount($all_Accounts)
    {
        return $this->checkAccount($all_Accounts, $this->from_Account_Number);
    }
    function toAccount($all_Accounts)
    {
        return $this->checkAccount($all_Accounts, $this->to_Account_Number);
    }
    private function checkAccount($all_Accounts, $accountNumber)
    {
        $account = GetAccountByNumber($all_Accounts, $accountNumber);
        PanicIf(!$account, "Invalid Account number " . $accountNumber);
        return $account;
    }

    function dateToString()
    {
        static $months = array(0,'Jan','Feb','Mar','Apr',
                                'May','June','July','Aug',
                                'Sep','Oct','Nov','Dec');
        return sprintf("%s %02d %s", $months[$this->month], $this->day, $this->year);
    }

public $month;
public $day;
public $year;
public $number;
public $from_Account_Number;
public $to_Account_Number;
public $amount;
}
?>