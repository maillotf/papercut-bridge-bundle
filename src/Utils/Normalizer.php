<?php

namespace MaillotF\Papercut\PapercutBridgeBundle\Utils;

/**
 * Description of Normalizer
 *
 * @author Flavien Maillot "contact@webcomputing.fr"
 */
class Normalizer
{
	public static $alphaSearch = array();
	public static $alphaReplace = array();

	public static function init()
	{
		if (empty(self::$alphaSearch))
			foreach (range('A', 'Z') as $value)
			{
				self::$alphaSearch[] = $value;
				self::$alphaReplace[] = '-' . strtolower($value);
			}
	}
	
	public static function normalize(string $value): string
	{
		self::init();
		return (str_replace(self::$alphaSearch, self::$alphaReplace, $value));
	}
	
	public static function normalizeArray(array $values): array
	{
		self::init();
		foreach ($values as $key => $value)
		{
			$values[$value] = array(
				'setter' => 'set'.ucfirst($value),
				'getter' => 'get'.ucfirst($value),
				'property' => str_replace(self::$alphaSearch, self::$alphaReplace, $value)
				);
			unset($values[$key]);
		}
		return ($values);
	}
}
