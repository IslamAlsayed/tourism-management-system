<?php

namespace Modules\Restaurants\Contracts;

interface RestaurantRepositoryInterface
{
    public function find($id);

    public function all();

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);

    public function findBy(string $column, $value);

    public function where(array $where);

    public function paginate(int $perPage = 15);

    public function count();

    public function filter(array $filters);
}
