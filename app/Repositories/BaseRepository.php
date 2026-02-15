<?php

namespace App\Repositories;

use App\Contracts\RepositoryInterface;

abstract class BaseRepository implements RepositoryInterface
{
    protected $model;

    abstract public function getModel();

    public function __construct()
    {
        $this->model = $this->getModel();
    }

    // abstract public function getModel();

    // public function __construct()
    // {
    //     $this->setModel();
    // }

    // private function setModel()
    // {
    //     $modelClass = $this->getModel();
    //     $this->model = new $modelClass();
    // }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function all()
    {
        return $this->model->all();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $model = $this->find($id);

        if ($model) {
            $model->update($data);
            return $model;
        }

        return null;
    }

    public function delete($id)
    {
        $model = $this->find($id);

        if ($model) {
            return $model->delete();
        }

        return false;
    }

    public function findBy(string $column, $value)
    {
        return $this->model->where($column, $value)->first();
    }

    public function where(array $where)
    {
        return $this->model->where($where)->get();
    }

    public function paginate(int $perPage = 15)
    {
        return $this->model->paginate($perPage);
    }

    public function count()
    {
        return $this->model->count();
    }

    public function filter(array $filters)
    {
        $query = $this->model->query();

        foreach ($filters as $column => $value) {
            if (! is_null($value)) {
                $query->where($column, 'like', "%{$value}%");
            }
        }

        return $query->get();
    }
}
