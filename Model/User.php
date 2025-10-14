<?php
class User extends Profile
{
  private $gender;
  private $cardNumber;

  public function __construct($email, $username, $password, $name, $lastname, $telephone, $gender, $cardNumber, $id = null)
  {
    parent::__construct($id, $email, $username, $password, $name, $lastname, $telephone);
    $this->gender = $gender;
    $this->cardNumber = $cardNumber;
  }

  public function getGender()
  {
    return $this->gender;
  }

  public function setGender($gender)
  {
    $this->gender = $gender;
  }

  public function getCardNumber()
  {
    return $this->cardNumber;
  }

  public function setCardNumber($cardNumber)
  {
    $this->cardNumber = $cardNumber;
  }

  public function show()
  {
    return "[USER - " . parent::show() . " - Gender: $this->gender - Card Number: $this->cardNumber]";
  }
}
