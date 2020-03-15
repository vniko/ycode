<?php namespace App\Repositories;

use App\Models\Website;

class WebsiteRepository
{

    protected $model;

    public function __construct(Website $model)
    {
        $this->model = $model;
    }

    // Get query with filters and order by applied
    // Normally for filters i would use some more powerfull stuff
    // like a search engine + Scout
    public function query($params)
    {
       $query = $this->model->newQuery();

       // search for filter substring
       if (!empty($params['filter'])) {
           $query->where('name', 'like', '%'.$params['filter'].'%')
                ->orWhere('url', 'like', '%'.$params['filter'].'%');
       }

       // apply order
       if (!empty($params['orderBy'])) {
           $query->orderBy($params['orderBy'], $params['orderDir'] ?? 'asc' );
       } else {
           $query->orderBy('name', 'asc');
       }

       return $query;
    }

    // create a new record in the database
    public function create(array $data)
    {
        return $this->model->create($data);
    }
}