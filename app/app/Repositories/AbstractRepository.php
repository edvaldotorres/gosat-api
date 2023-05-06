<?php

namespace App\Repositories;

use App\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository implements RepositoryInterface
{
    protected static $model;

    public static function all(): Collection
    {
        return self::loadModel()::all();
    }

    public static function create(array $data): Model|null
    {
        return self::loadModel()::query()->create($data);
    }

    public static function updateOrCreate(array $data, array $condition): Model|null
    {
        return self::loadModel()::query()->updateOrCreate($condition, $data);
    }

    public static function find(int $id): Model|null
    {
        return self::loadModel()::query()->find($id);
    }

    public static function delete(int $id): int
    {
        return self::loadModel()::query()->where('id', $id)->delete();
    }

    public static function update(array $data, int $id): int
    {
        return self::loadModel()::query()->where('id', $id)->update($data);
    }

    public static function loadModel(): Model
    {
        return app(static::$model);
    }
}
