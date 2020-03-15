<?php

namespace App\Transformers;

use App\Models\Website;
use League\Fractal\TransformerAbstract;
use Fractal;

class WebsiteTransformer extends TransformerAbstract
{

    public function transform(Website $website)
    {
        return [
            'id' => $website->id,
            'name' => $website->name,
            'url' => $website->url
        ];
    }

}
