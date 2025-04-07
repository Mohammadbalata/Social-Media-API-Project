<?php

namespace App\Repositories\Interfaces;

interface BaseRepositoryInterface
{
    public function all(array $columns = ['*']);
    public function find(int $id);
    public function create(array $data);
    public function update($model, array $data);
    public function delete($model);
    public function paginate(int $perPage = 15, array $columns = ['*']);
}