<?php

function create(string $class, array $attributes = [], $time = null)
{
    return factory($class, $time)->create($attributes);
}

function make(string $class, array $attributes = [], $time = null)
{
    return factory($class, $time)->make($attributes);
}
