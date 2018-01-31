<?php

namespace App\Controllers;

use App\Models\Podcast;

use League\Fractal\{
  Resource\Item,
  Resource\Collection,
  Pagination\IlluminatePaginatorAdapter
};

use App\Transformers\PodcastTransformer;

class PodcastController extends Controller
{
  public function index($request, $response)
  {
    $podcasts = Podcast::latest()->paginate(2);

    $transformer = (new Collection($podcasts->getCollection(), new PodcastTransformer))->setPaginator(new IlluminatePaginatorAdapter($podcasts));

    return $response->withJson( $this->container->fractal->createData($transformer)->toArray() );
  }

  public function show($request, $response, $args)
  {

    $podcast = Podcast::find($args['id']);

    if($podcast === null){
      return $response->withStatus(404)->withJson([
        'errors' => [
          'title' => 'Podcast Not Found'
        ]
      ]);
    }

    $transformer = new Item($podcast, new PodcastTransformer);

    return $response->withJson( $this->container->fractal->createData($transformer)->toArray() );

  }
}
