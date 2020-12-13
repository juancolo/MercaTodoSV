<?php

namespace App\Repository;

abstract class BaseRepositories
{
    abstract public function getModel();

    /**
     * @param null $request
     * @return mixed
     */
    public function getAll($request = null): mixed
    {
        return $this->getModel()->all($request);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        return $this->getModel()->create($data);
    }

    /**
     * @param $object
     * @param $data
     * @return void
     */
    public function update($object, $data): void
    {
        $object->fill($data);
        $object->save();
    }

    /**
     * @param $object
     */
    public function delete($object)
    {
        $object->delete();
    }
}
