<?php
class User
{

    public $iduser;
    public $username;
	public $first_name;
	public $last_name;
	public $email;
	public $created;

    function __construct()
    {
		$iduser=0;
		$username=$first_name=$last_name=$email=$created="";
    }
}
?>