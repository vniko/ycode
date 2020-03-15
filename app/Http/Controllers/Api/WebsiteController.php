<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\WebsiteCreateRequest;
use App\Models\Website;
use App\Repositories\WebsiteRepository;
use Illuminate\Http\Request;

class WebsiteController extends \App\Http\Controllers\Controller
{

    /**
     * @var WebsiteRepository
     */
    protected $repo;


    public function __construct()
    {
        $this->repo = new WebsiteRepository(new Website());
    }


    /**
     * @api {get} /api/website Get a list of websites
     * @apiVersion 0.0.1
     * @apiName get-websites
     * @apiParam {string} filter Search Filter String
     * @apiParam {string} orderBy Order By Column Name
     * @apiParam {string} orderDir Order By Direction
     * @apiGroup Website
     * @apiSuccessExample {json} Success Response Example
     * {
        "data": [
        {
            "id": 11,
            "name": "Baumbach-Crooks Website",
            "url": "http://www.schumm.com/"
         },
        {
            "id": 21,
            "name": "Beahan-Kuhic Website",
            "url": "https://weber.com/est-qui-reiciendis-vel-aut.html"
        },
        ]
     }
     *
     *
     */
    public function index(Request $request)
    {
        return
            $this->repo
                ->query($request->all())
                    ->fractalPagination($request->all())
                        ->respond();
    }

    /**
     * @api {post} /api/website Create a New Website
     * @apiVersion 0.0.1
     * @apiName create-website
     * @apiParam {string} name Name of the Webiste
     * @apiParam {string} url URL of the Website
     * @apiGroup Website
     */
    public function store(WebsiteCreateRequest $request)
    {
        $input = $request->only('name', 'url');

        $website = $this->repo->create($input);

        return response()->json(
            [
                'website' => $website
            ],
            201
        );
    }


}