<?php

namespace MaillotF\Papercut\PapercutBridgeBundle\Service;

use PhpXmlRpc;
use MaillotF\Papercut\PapercutBridgeBundle\Objects\User;

/**
 * Class User
 *
 * @package MaillotF\Papercut\PapercutBridgeBundle\Service
 * @author Flavien Maillot "contact@webcomputing.fr"
 */
class UserService extends AbstractPapercut implements UserServiceInterface
{

	public function __construct(
			string $path,
			string $token,
			?string $protocol = null,
			?string $host = null,
			?int $port = null
	)
	{
		parent::__construct($path, $token, $protocol, $host, $port);
	}

	/**
	 * Get an user property
	 * 
	 * @param string $propertyName
	 * @param string $username
	 * @return string
	 * @author Flavien Maillot 
	 */
	public function getProperty(string $propertyName, string $username): string
	{
		$result = $this->request('getUserProperty', array(
			new PhpXmlRpc\Value($username, 'string'),
			new PhpXmlRpc\Value($propertyName, 'string')
		));
		return ($result);
	}

	/**
	 * Save an user property
	 *
	 * @param string $propertyName
	 * @param string $username
	 * @param mixed $value
	 * @return bool success or fail
	 * @author Flavien Maillot 
	 */
	public function saveProperty(string $propertyName, string $username, $value): bool
	{
		return $this->request('setUserProperty', array(
					new PhpXmlRpc\Value($username, 'string'),
					new PhpXmlRpc\Value($propertyName, 'string'),
					new PhpXmlRpc\Value($value, 'string'),
		));
	}

	/**
	 * Save an user
	 * 
	 * @param User $user
	 * @return bool success or fail
	 */
	public function saveUser(User $user): bool
	{
		$userProperties = $user->getProperties();
		$xmlProperties = array();
		foreach ($userProperties as $userProperty)
		{
			$getter = $userProperty['getter'];
			$value = $user->$getter();
			$property = array(
				new PhpXmlRpc\Value($userProperty['property'], 'string'),
				new PhpXmlRpc\Value($value, 'string')
			);
			$xmlProperties[] = new PhpXmlRpc\Value($property, 'array');
		}
		if ($user->getPassword() != null && $user->getPassword() != '')
		{
			$property = array(
				new PhpXmlRpc\Value('password', 'string'),
				new PhpXmlRpc\Value($user->getPassword(), 'string')
			);
			$xmlProperties[] = new PhpXmlRpc\Value($property, 'array');
		}

		return $this->request('setUserProperties', array(
					new PhpXmlRpc\Value($user->getUsername(), 'string'),
					new PhpXmlRpc\Value($xmlProperties, 'array')
		));
	}

	/**
	 * Get an user
	 * 
	 * @param string $username
	 * @return User
	 * @author Flavien Maillot 
	 */
	public function getUser(string $username): User
	{
		$user = new User();
		$user->setUsername($username);
		$userProperties = $user->getProperties();
		$xmlProperties = array();
		foreach ($userProperties as $userProperty)
		{
			$xmlProperties[] = new PhpXmlRpc\Value($userProperty['property'], 'string');
		}

		$properties = $this->request('getUserProperties', array(
			new PhpXmlRpc\Value($username, 'string'),
			new PhpXmlRpc\Value($xmlProperties, 'array')
		));

		foreach ($properties as $value)
		{
			$setter = current($userProperties)['setter'];
			$user->$setter($value['string']);
			next($userProperties);
		}

		return $user;
	}

	/**
	 * Get a username by the card number
	 * 
	 * @param string $revhex
	 * @return string
	 * @author Flavien Maillot 
	 */
	public function getUsernameByCardNo(string $revhex): string
	{
		$username = $this->request('lookUpUserNameByCardNo', array(
			new PhpXmlRpc\Value($revhex, 'string')));
		return ($username);
	}

	/**
	 * Get all username in a list
	 * 
	 * @return array
	 * @throws \RuntimeException
	 * @author Flavien Maillot 
	 */
	public function getUsernameList(): array
	{
		$result = $this->request('listUserAccounts', array(new PhpXmlRpc\Value(0, 'int'), new PhpXmlRpc\Value(0, 'int')));

		$usersList = array();
		if (!is_array($result))
			throw new \RuntimeException($result);
		foreach ($result as $data)
			$usersList[] = $data['string'];

		return ($usersList);
	}

	/**
	 * Check if user existe
	 * 
	 * @param string $username
	 * @return bool
	 * @author Flavien Maillot 
	 */
	public function isUserExists(string $username): bool
	{
		$result = $this->request('isUserExists', array(
			new PhpXmlRpc\Value($username, 'string')
		));

		return $result;
	}

	/**
	 * Adjust $amount to the $username papercut balance
	 * 
	 * @param string $username
	 * @param float $amount
	 * @param string $label
	 * @return bool
	 * @author Flavien Maillot 
	 */
	public function adjustBalance(string $username, float $amount, string $label = 'Adjust balance by Papercut bridge'): bool
	{
		return ($this->request('adjustUserAccountBalance', array(
					new PhpXmlRpc\Value($username, 'string'),
					new PhpXmlRpc\Value($amount, 'double'),
					new PhpXmlRpc\Value($label, 'string'),
		)));
	}

	/**
	 * Get User balance
	 * 
	 * @param string $username
	 * @return string
	 * @author Flavien Maillot 
	 */
	public function getBalance(string $username): float
	{
		$balance = $this->request('getUserAccountBalance', array(
			new PhpXmlRpc\Value($username, 'string')
		));

		return (floatval($balance));
	}

	/**
	 * Get User account balance rounded
	 * 
	 * @param string $username
	 * @return string
	 * @author Flavien Maillot 
	 */
	public function getBalanceRounded(string $username): float
	{
		return (round($this->getBalance($username), 2));
	}

	/**
	 * Delete user account
	 * 
	 * @param string $username
	 * @return bool
	 * @author Flavien Maillot 
	 */
	public function deleteUser(string $username): bool
	{
		if ($this->request('deleteExistingUser', array(
					new PhpXmlRpc\Value($username, 'string')
				)) === true)
			return true;
		return false;
	}

	/**
	 * Create user from User object. 
	 * Only use username, password, fullname, email, primaryCardNumber
	 * 
	 * @param User $user
	 * @return bool
	 */
	public function createUser(User $user): bool
	{
		return ($this->createUserByParams($user->getUsername(), $user->getPassword(), $user->getFullname(), $user->getEmail(), $user->getPrimaryCardNumber()));
	}

	/**
	 * Create user account with card
	 * 
	 * @param array $params
	 * @return bool
	 * @author Flavien Maillot 
	 */
	public function createUserByParams(string $username, string $password, string $fullname, string $email, string $card): bool
	{
		if (strpos($ret = $this->request('addNewInternalUser', array(
					new PhpXmlRpc\Value($username, 'string'),
					new PhpXmlRpc\Value($password, 'string'),
					new PhpXmlRpc\Value($fullname, 'string'),
					new PhpXmlRpc\Value($email, 'string'),
					new PhpXmlRpc\Value($card, 'string'),
					new PhpXmlRpc\Value('', 'string')
						)), 'ERROR') === 0)
			return false;
		else
			return true;
	}

	/**
	 * Create user and handback previous card carrier if necessary
	 * 
	 * @param User $user
	 * @return bool
	 * @author Flavien Maillot 
	 */
	public function createUserWithHandback(User $user): bool
	{
		//Fail if card is linked to another contact
		if (!$this->createUser($user))
		{
			//get previous carrier or return false for error
			if (empty($previousCarrier = $this->getUsernameByCardNo($user->getPrimaryCardNumber())))
				return (false);
			else
			{
				//Try to handback previous carrier card or return false for error
				if (($change = $this->saveProperty('primary-card-number', $previousCarrier, "OLD_${previousCarrier}_${card}")) !== true)
					return (false);
				//Try again to create the user or return false for error
				if (!$this->createUser($user))
					return (false);
			}
		}
		return (true);
	}

	/**
	 * Create a papercut user if it doesn't exist
	 * 
	 * @param string $username
	 * @param string $password
	 * @param string $fullname
	 * @param string $email
	 * @param string $card
	 * @return bool
	 * @author Flavien Maillot 
	 */
	public function createUserIfDoesntExist(User $user): bool
	{
		if ($this->isUserExists($user->getUsername()) !== true)
		{
			if ($this->createUserWithHandback($user) == false)
				return (false);
			if (boolval($user->getRestricted()) == false)
				$this->saveProperty('restricted', $user->getUsername(), $user->getRestricted());
			if ($user->getSecondaryCardNumber() == '')
				$this->saveProperty('secondary-card-number', $user->getUsername(), $user->getEmail());
			else
				$this->saveProperty('secondary-card-number', $user->getUsername(), $user->getSecondaryCardNumber());
			return (true);
		}
		else
			return (false);
	}

	/**
	 * Get total user registered
	 * 
	 * @return int
	 * @author Flavien Maillot 
	 */
	public function countTotalUsers(): int
	{
		return $this->request('getTotalUsers', array());
	}

	/**
	 * Helper to change the password for an user
	 * 
	 * @param string $username
	 * @param string $password
	 * @return bool
	 * @author Flavien Maillot 
	 */
	public function changePassword(string $username, string $password): bool
	{
		$result = $this->saveProperty('password', $username, $password);
		if ($result === true)
			return (true);
		return (false);
	}

	/**
	 * Change the primary primary card for a user
	 * 
	 * @param string $username
	 * @param string $revhex
	 * @return array
	 * @author Flavien Maillot 
	 */
	public function changePrimaryCardNumber(string $username, string $revhex, bool $strict = false): array
	{
		$result = $this->saveProperty('primary-card-number', $username, $revhex);
		$matches = array();
		if ($result === true)
			return true;
		else if (preg_match('/.* number for user .* Card number: (.*)/', $result, $matches) == true && $strict == true)
			throw new PapercutException('Unique constrainte', 409);
		if ($strict == true)
			throw new PapercutException($result, 500);
	}

	/**
	 * Change the primary primary card for a user
	 * 
	 * @param string $username
	 * @param string $revhex
	 * @param bool $strict
	 * @return array
	 * @throws PapercutException
	 * @author Flavien Maillot 
	 */
	public function changeSecondaryCardNumber(string $username, string $revhex, bool $strict = false): array
	{
		$result = $this->saveProperty('secondary-card-number', $username, $revhex);
		$matches = array();
		if ($result === true)
			return true;
		else if (preg_match('/.* number for user .* Card number: (.*)/', $result, $matches) == true && $strict == true)
			throw new PapercutException('Unique constrainte', 409);
		if ($strict == true)
			throw new PapercutException($result, 500);
	}

	/**
	 * Handback the card if it was link to another user, then link the primary card to the new user
	 * 
	 * @param string $username
	 * @param string $revhex
	 * @param type $strict
	 * @return array
	 * @author Flavien Maillot 
	 */
	public function handbackAndChangeUserPrimaryCardNumber(string $username, string $revhex, $strict = false): array
	{
		if (!empty($previousOwner = $this->getUsernameByCardNo($revhex)))
		{
			$result = $this->changePrimaryCardNumber($previousOwner, "OLD_${previousOwner}_${revhex}", $strict);
			if ($result !== true)
				return (false);
		}
		return ($this->changePrimaryCardNumber($username, $revhex, $strict));
	}

}
