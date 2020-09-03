<?php
class User
{

    public $username;
	public $first_name;
	public $last_name;
	public $email;

    function __construct()
    {
		$username=$first_name=$last_name=$email="";
    }
}
?>