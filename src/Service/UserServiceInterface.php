<?php

namespace MaillotF\Papercut\PapercutBridgeBundle\Service;

use MaillotF\Papercut\PapercutBridgeBundle\Objects\User;

/**
 *
 * @author Flavien Maillot "contact@webcomputing.fr"
 */
interface UserServiceInterface
{

	public function getProperty(string $propertyName, string $username): string;

	public function saveProperty(string $propertyName, string $username, $value): bool;

	public function saveUser(User $user): bool;

	public function getUser(string $username): User;

	public function getUsernameByCardNo(string $revhex): string;

	public function getUsernameList(): array;

	public function isUserExists(string $username): bool;

	public function adjustBalance(string $username, float $amount, string $label = 'Adjust balance by Papercut bridge'): bool;

	public function getBalance(string $username): float;

	public function getBalanceRounded(string $username): float;

	public function deleteUser(string $username): bool;

	public function createUser(User $user): bool;

	public function createUserByParams(string $username, string $password, string $fullname, string $email, string $card): bool;

	public function createUserWithHandback(User $user): bool;

	public function createUserIfDoesntExist(User $user): bool;

	public function countTotalUsers(): int;

	public function changePassword(string $username, string $password): bool;

	public function changePrimaryCardNumber(string $username, string $revhex, bool $strict = false): array;

	public function changeSecondaryCardNumber(string $username, string $revhex, bool $strict = false): array;

	public function handbackAndChangeUserPrimaryCardNumber(string $username, string $revhex, $strict = false): array;
}
