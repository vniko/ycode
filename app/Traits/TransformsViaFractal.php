<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\TransformerAbstract;

trait TransformsViaFractal
{
    /**
     * Convert current item into a fractal instance.
     *
     * @param array $includes nested relationships to include
     *
     * @return Spatie\Fractal\Fractal
     */
    public function toFractal(array $includes = [], TransformerAbstract $transformer = null)
    {
        $transformer = $transformer ?? $this->newTransformer();
        return fractal()
            ->item($this, $transformer)
                ->parseIncludes($includes);
    }


    /**
     * Extends the query builder using macros.
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function newQuery()
    {
        $query = parent::newQuery();
        $instance = new self();

        /*
         * Paginate the query and wrap the paginator with fractal.
         *
         * @var null
         */
        $query->macro('fractalPagination', function (Builder $builder, $parameters = []) use ($instance) {

            $includes = $parameters['includes'] ?? [];
            $perPage = $parameters['per_page'] ?? 10;
            $columns = $parameters['columns'] ?? ['*'];
            $pageName = $parameters['page_name'] ?? 'page';
            $page = $parameters['page'] ?? null;
            $limit = $parameters['limit'] ?? null;
            $offset = $parameters['offset'] ?? 0;
            $paginator = null;

            if (!is_null($limit)) {
                // no paginator - just slice
                $collection = $builder->offset($offset)
                    ->take($limit)
                    ->get();
            } else {
                $paginator = $builder->paginate($perPage, $columns, $pageName, $page);
                $collection = $paginator->getCollection();
            }

            $returnQuery = fractal()
                ->collection($collection, $instance->newTransformer())
                ->parseIncludes($includes);

            if ($paginator) {
                $returnQuery->paginateWith(new IlluminatePaginatorAdapter($paginator));
            }

            return $returnQuery;
        });

        return $query;
    }


    /**
     * Extend the model collection with a toFractal method.
     *
     * @param array $models
     *
     * @return Spatie\Fractal\Fractal
     */
    public function newCollection(array $models = [])
    {
        $instance = new self();

        $collection = parent::newCollection($models);

        $collection->macro('toFractal', function ($includes = []) use ($instance) {
            return fractal()
                ->collection($this, $instance->newTransformer())
                    ->parseIncludes($includes);
        });

        return $collection;
    }

    /**
     * Create a new fractal transformer instance via ioc container.
     *
     * @return League\Fractal\TransformerAbstract
     */
    public function newTransformer()
    {
        return app('App\\Transformers\\' . class_basename($this) . 'Transformer');
    }
}
