<?php

namespace Tests\Unit;

use App\Application\Services\UserService;
use App\Models\Domain\Device;
use App\Models\Domain\User;
use App\Repositories\DeviceRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    protected $userService;
    protected $userRepositoryMock;
    protected $deviceRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepositoryMock = $this->createMock(UserRepository::class);
        $this->deviceRepositoryMock = $this->createMock(DeviceRepository::class);

        $this->userService = new UserService($this->userRepositoryMock, $this->deviceRepositoryMock);
    }

    public function testRegister()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
        ];

        $user = new User();
        $user->fill($userData);

        $this->userRepositoryMock->expects($this->once())
            ->method('store')
            ->with($userData)
            ->willReturn($user);

        $result = $this->userService->register($userData);

        $this->assertInstanceOf(User::class, $result);
    }

    public function testLogin()
    {
        $credentials = [
            'email' => 'john@example.com',
            'password' => 'password123',
            'device_name' => 'device123',
        ];
    
        $validUser = new User();
        $validUser->email = $credentials['email'];
        $this->userRepositoryMock->expects($this->once())
            ->method('findByEmail')
            ->with('john@example.com')
            ->willReturn($validUser);
    
        Auth::shouldReceive('attempt')
            ->with(['email' => $credentials['email'], 'password' => $credentials['password']])
            ->andReturn(true);
    
        $this->deviceRepositoryMock->expects($this->once())
            ->method('findByName')
            ->with('device123')
            ->willReturn(new Device());
    
        $this->userRepositoryMock->expects($this->once())
            ->method('deleteAllTokens')
            ->with($validUser);
    
        $this->userRepositoryMock->expects($this->once())
            ->method('createToken')
            ->with($validUser)
            ->willReturn('auth_token');
    
        $result = $this->userService->login($credentials);
    
        $expectedResult = [
            'status' => true,
            'message' => null,
            'token' => 'auth_token',
        ];
    
        $this->assertEquals($expectedResult, $result);
    }
}