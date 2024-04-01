<?php

namespace App\Repositories;

use App\Models\Domain\Device;
use App\Models\Domain\Recipe;
use App\Repositories\DeviceRepositoryInterface;

class DeviceRepository implements DeviceRepositoryInterface
{
    public function findById(int $id): ?Device
    {
        return Device::select(
            'devices.id',
            'devices.name',
            'devices.users_id',
        )->find($id);
    }

    public function findByName(string $name): ?Device
    {
        return Device::select(
            'devices.id',
            'devices.name',
            'devices.users_id',
        )->where('devices.name', $name)
            ->firstOrFail();
    }

    public function removeAllReviewsFromRecipe(Recipe $recipe): ?Recipe
    {
        $recipe->reviews()->detach();

        return $recipe;
    }

    public function updateUserId(Device $device, $userId): ?Device
    {
        $device->update(['users_id' => $userId]);

        return $device;
    }
}
