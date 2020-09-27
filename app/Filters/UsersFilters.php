<?php

namespace App\Filters;

use App\Filters\QueryFilter;

class UsersFilters extends QueryFilter
{
    protected $availableIncludes = [
        'email'     => 'email',
    ];

    protected $defaultIncludes = [

    ];

    protected $searches = [
        'name' => 'ilike'
    ];
}
