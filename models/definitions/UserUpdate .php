<?php namespace app\models\definitions;
/**
*@OA\Schema(
 * @OA\Property(property="id", type="integer"),
 * @OA\Property(property="brand", type="string", example="Mercedes"),
 * @OA\Property(property="model", type="string", example="600"),
 * @OA\Property(property="year", type="string", format="date-time", example="2000"),
 * @OA\Property(property="color", type="string", example="синий"),
 * @OA\Property(property="registration", type="string"),
 * @OA\Property(property="vin", type="string", example="XXXXXXX"),
 * @OA\Property(property="sts", type="string", example="XXXXXXX"),
 * @OA\Property(property="license", type="string", example="XXXXXXXXXX"),
 * @OA\Property(property="id_users", type="integer"),
)
*/
class UserUpdate{}