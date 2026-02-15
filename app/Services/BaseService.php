<?php

namespace App\Services;

abstract class BaseService
{
    protected $repository;

    abstract public function getRepository();

    public function __construct()
    {
        $this->repository = $this->getRepository();
    }

    public function getAll()
    {
        return $this->repository->all();
    }

    public function getPaginated(int $perPage = 15)
    {
        return $this->repository->paginate($perPage);
    }

    public function getById($id)
    {
        return $this->repository->find($id);
    }

    public function store(array $data)
    {
        return $this->repository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }

    public function findByColumn(string $column, $value)
    {
        return $this->repository->findBy($column, $value);
    }

    public function filter(array $filters)
    {
        return $this->repository->filter($filters);
    }

    public function count()
    {
        return $this->repository->count();
    }
}
