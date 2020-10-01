<?php
namespace app\models\definitions;
/**
 * @OA\Schema(
 * @OA\Property(property="phone", type="string", example="79991234567"),
 * @OA\Property(property="token", type="string", example="djskalfjdureksldsforieuwoqiwue"),
 * @OA\Property(property="status", type="string",enum={"1", "2", "3", "9", "10"}),
 * @OA\Property(property="create_at", type="string", format="date-time"),
	@OA\Property(property="permissions", type="array",
		@OA\Items(type="string", enum={"createProfile", "viewOwnCar", "viewOwnProfile"})
	)
 ),
	@OA\Property(property="roles", type="array",
		@OA\Items(type="string", enum={"candidate", "user", "admin"})
	)
 ),
	@OA\Property(property="profile", type="object",
		ref="#/components/schemas/ProfileResponse"
	)
 ),

    "usersAgregators": []
 */
 class UserResponse{}
 