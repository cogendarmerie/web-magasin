<?php

namespace Infra;

interface DatabaseInterface
{
    public function findAll();
    public function findOneById(string $id);
    public function update(string $id, object $object);
    public function insert(object $object);
    public function delete(string $id);
}