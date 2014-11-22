<?php
class Account
{
public function __toString()
{
	return "Account Object:\n".$this->number . " \n" 
			.$this->name . " \n" 
			.$this->type . " \n" 
			.$this->interest . " \n" 
			.$this->budget . " \n" 
			.$this->start . " \n";
}
public function __jsonArrayItem()
{
	return "{" 
		. "\"id\": \"" . $this->number . "\"," 
		. "\"name\": \"" . $this->name . "\"," 
		. "\"type\": \"" . $this->type . "\","
		. "\"interest\": \"" . $this->interest . "\","
		. "\"budget\": \"" . $this->budget . "\","
		. "\"start\": \"" . $this->start . "\""
		. "}";
		
		
}
public function __json()
{
	return "{\"account\": {" 
		. "\"id\": \"" . $this->number . "\"," 
		. "\"name\": \"" . $this->name . "\"," 
		. "\"type\": \"" . $this->type . "\","
		. "\"interest\": \"" . $this->interest . "\","
		. "\"budget\": \"" . $this->budget . "\","
		. "\"start\": \"" . $this->start . "\""
		. "}}";
		
		
}

public $number;
public $name;
public $type;
public $interest;
public $budget;
public $start;
}
class AccountType
{
public $type;
public $accounts;
}
?>