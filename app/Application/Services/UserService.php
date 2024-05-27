<?php

namespace App\Application\Services;

use App\Repositories\DeviceRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserService implements UserServiceInterface
{
    protected $userRepository;
    protected $deviceRepository;

    public function __construct(UserRepositoryInterface $userRepository, DeviceRepositoryInterface $deviceRepository)
    {
        $this->userRepository = $userRepository;
        $this->deviceRepository = $deviceRepository;
    }

    public function register(array $userData)
    {
        return DB::transaction(function () use ($userData) {
            $user = $this->userRepository->store($userData);

            return $user;
        });
    }

    public function login(array $credentials)
    {
        return DB::transaction(function () use ($credentials) {
            $response = [];

            if (!Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
                $response["status"] = false;
                $response["message"] = "Invalid login details";
                $response["token"] = null;

                return $response;
            }

            $user = $this->userRepository->findByEmail($credentials['email']);
            $deviceName = $credentials['device_name'];
            $device = $this->deviceRepository->findByName($deviceName);

            if (!$device->users_id || $device->users_id == $user->id) {
                $this->userRepository->deleteAllTokens($user);
                $this->deviceRepository->updateUserId($device, $user->id);
                $response["status"] = true;
                $response["message"] = null;
                $response["token"] = $this->userRepository->createToken($user);

                return $response;
            } else {
                $response["status"] = false;
                $response["message"] = "Invalid device name";
                $response["token"] = null;

                return $response;
            }
        });
    }
}
