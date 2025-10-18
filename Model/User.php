<?php
include_once 'Gender.php';
include_once 'Profile.php';

class User extends Profile
{
  private $u_gender;
  private $u_cardNumber;

  public function __construct($p_email, $p_username, $p_password, $p_name, $p_lastname, $p_telephone, $u_gender, $u_cardNumber, $p_id = null)
  {
    parent::__construct($p_id, $p_email, $p_username, $p_password, $p_name, $p_lastname, $p_telephone);
    $this->u_gender = $u_gender;
    $this->u_cardNumber = $u_cardNumber;
  }

  public function getGender()
  {
    return $this->u_gender;
  }

  public function setGender($gender)
  {
    $this->u_gender = $gender;
  }

  public function getCardNumber()
  {
    return $this->u_cardNumber;
  }

  public function setCardNumber($cardNumber)
  {
    $this->u_cardNumber = $cardNumber;
  }

  public function show()
  {
    return "[USER - " . parent::toString() . " - Gender: $this->u_gender - Card Number: $this->u_cardNumber]";
  }
}
