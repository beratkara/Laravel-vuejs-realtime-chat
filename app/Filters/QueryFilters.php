<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use PDOException;

abstract class QueryFilter
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
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param Builder $builder
     */
    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->filters() as $name => $value) {
            if (method_exists($this, $name)) {
                call_user_func_array([$this, $name], (array)$value);
            }
        }

        if ($this->defaultIncludes) {
            $this->builder->with($this->defaultIncludes);
        }
    }

    /**
     * @return array
     */
    protected function filters(): array
    {
        return array_filter(
            array_map('trim', $this->request->all())
        );
    }

    /**
     * @param $value
     */
    public function searches($value)
    {
        if (isset($this->searches) && is_array($this->searches)) {
            $this->builder->where(function ($query) use ($value) {
                foreach ($this->searches as $key => $rule) {
                    $query->orWhere($key, $rule, '%'.$value.'%');
                }
            });
        }
    }

    public function orderBy($value)
    {
        $this->request->validate([
            'sortedBy' => 'required|in:asc,desc',
            'orderBy' => 'required'
        ]);
        $sortedBy = $this->request->get('sortedBy', 'desc');
        $this->builder->orderBy($value, $sortedBy);
    }

    public function include($value)
    {
        $includes = explode(',', $value);
        foreach ($includes as $item) {
            if(in_array($item, $this->availableIncludes)) {
                $this->builder->with($item);
            }
        }
    }
}
