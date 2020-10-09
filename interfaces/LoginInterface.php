<?php namespace app\interfaces;
interface LoginInterface{
	public function loginAll(array $names);
	public function loginByName(string $name);
}