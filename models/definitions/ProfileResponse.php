<?php
namespace app\models\definitions;
/**
 * @OA\Component(),
 * @OA\Schema(
 * @OA\Property(property="id", type="integer"),
 * @OA\Property(property="firstname", type="string"),
 * @OA\Property(property="lastname", type="string"),
 * @OA\Property(property="birthdate", type="string", format="date-time"),
 * @OA\Property(property="phone", type="string"),
	@OA\Property(property="passport", type="object",

	@OA\Property(property="series", type="string"),
	@OA\Property(property="number", type="string"),
	@OA\Property(property="date", type="string", format="date-time"),
	@OA\Property(property="address", type="string")

 ),
 @OA\Property(property="license", type="object",

			@OA\Property(property="series", type="string"),
			@OA\Property(property="number", type="string"),
			@OA\Property(property="date", type="string", format="date-time"),
			@OA\Property(property="expire", type="string", format="date-time")

	),

 )
 */
 class ProfileResponse{}
 