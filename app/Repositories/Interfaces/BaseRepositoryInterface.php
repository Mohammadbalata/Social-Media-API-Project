<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    public function all(array $columns = ['*']);
    public function find(int $id);
    public function create(array $data);
    public function update(Model $model, array $data);
    public function delete(Model $model);
    public function paginate(int $perPage = 15, array $columns = ['*']);
}