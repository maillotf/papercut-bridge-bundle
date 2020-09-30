<?php

namespace MaillotF\Papercut\PapercutBridgeBundle\Objects;

/**
 * Description of User
 *
 * @author Flavien Maillot "contact@webcomputing.fr"
 */
class User
{
	private $username;
	
	private $password;
	
	private $fullName;
	
	private $email;
	
	private $balance;
	
	private $primaryCardNumber;
	
	private $secondaryCardNumber;
	
	private $restricted;
	
	public function getProperties(): array
	{
		$properties = array_keys(get_object_vars($this));
		unset($properties[0]);
		unset($properties[1]);
		return \MaillotF\Papercut\PapercutBridgeBundle\Utils\Normalizer::normalizeArray($properties);
	}
	
	public function setUsername(string $username)
	{
		$this->username = $username;
		return $this;
	}
	
	public function getUsername(): string
	{
		return $this->username;
	}

	public function setPassword(string $password)
	{
		$this->password = $password;
		return $this;
	}
	
	public function getPassword(): string
	{
		return $this->password;
	}

	public function setFullname(string $fullName)
	{
		$this->fullName = $fullName;
		return $this;
	}

	public function getFullname(): string
	{
		return $this->fullName;
	}

	public function setEmail(string $email)
	{
		$this->email = $email;
		return $this;
	}

	public function getEmail(): string
	{
		return $this->email;
	}

	public function setBalance(string $balance)
	{
		$this->balance = $balance;
		return $this;
	}

	public function getBalance(): string
	{
		return $this->balance;
	}

	public function setPrimaryCardNumber(string $primaryCardNumber)
	{
		$this->primaryCardNumber = $primaryCardNumber;
		return $this;
	}
	public function getPrimaryCardNumber(): string
	{
		return $this->primaryCardNumber;
	}

	public function setSecondaryCardNumber(string $secondaryCardNumber)
	{
		$this->secondaryCardNumber = $secondaryCardNumber;
		return $this;
	}
	public function getSecondaryCardNumber(): string
	{
		return $this->secondaryCardNumber;
	}

	public function setRestricted(string $restricted)
	{
		$this->restricted = $restricted;
		return $this;
	}
	
	public function getRestricted(): string
	{
		return $this->restricted;
	}

}
