<?php


namespace App\Filters;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

abstract class Filter
{
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var Builder
     */
    protected $builder;

    /**
     * @var array
     */
    protected $filters = [];

    /**
     * ThreadFilter constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        $this->getFilters()
            ->filter(fn($filter) => method_exists($this, $filter))
            ->each(fn ($filter, $value) => [$this->$filter($value)]);

        return $this->builder;

    }

    /**
     * @return Collection
     */
    private function getFilters(): Collection
    {
        return collect($this->request->only($this->filters))->flip();
    }
}
