<?php

namespace app\models\definitions;

/**
  * @OA\Schema(
  schema="ProfileUpdate",
 * @OA\Property(property="firstname", type="string", example="Иван"),
 * @OA\Property(property="secondname", type="string", example="Иванович"),
 * @OA\Property(property="lastname", type="string", example="Иванов"),
 * @OA\Property(property="birthdate", type="string", format="date-time", example="21.20.2001"),
 * @OA\Property(property="phone", type="string", example="79991234567"),
	@OA\Property(property="passport_series", type="string", example="XXXX"),
	@OA\Property(property="passport_number", type="string", example="XXXXXX"),
	@OA\Property(property="passport_giver", type="string"),
	@OA\Property(property="passport_date", type="string", format="date-time", example="21.01.2008"),
	@OA\Property(property="registration_address", type="string"),
	 @OA\Property(property="license_series", type="string", example="XXXX"),
	 @OA\Property(property="license_number", type="string", example="XXXXXX"),
	 @OA\Property(property="license_date", type="string", format="date-time", example="21.01.2015"),
	 @OA\Property(property="license_expire", type="string", format="date-time", example="21.05.2025"),
	 @OA\Property(property="user_id", type="integer")


 )
 */