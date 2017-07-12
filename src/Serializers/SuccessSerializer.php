<?php

namespace Flugg\Responder\Serializers;

use League\Fractal\Pagination\CursorInterface;
use League\Fractal\Pagination\PaginatorInterface;
use League\Fractal\Resource\ResourceInterface;
use League\Fractal\Serializer\ArraySerializer;

/**
 * A serializer class responsible for formatting success data.
 *
 * @package flugger/laravel-responder
 * @author  Alexander Tømmerås <flugged@gmail.com>
 * @license The MIT License
 */
class SuccessSerializer extends ArraySerializer
{
    /**
     * Serialize collection resources.
     *
     * @param  string $resourceKey
     * @param  array  $data
     * @return array
     */
    public function collection($resourceKey, array $data)
    {
        return ['data' => $data];
    }

    /**
     * Serialize item resources.
     *
     * @param  string $resourceKey
     * @param  array  $data
     * @return array
     */
    public function item($resourceKey, array $data)
    {
        return ['data' => $data];
    }

    /**
     * Serialize null resources.
     *
     * @return array
     */
    public function null()
    {
        return ['data' => null];
    }

    /**
     * Format meta data.
     *
     * @param  array $meta
     * @return array
     */
    public function meta(array $meta)
    {
        return $meta;
    }

    /**
     * Format pagination data.
     *
     * @param  \League\Fractal\Pagination\PaginatorInterface $paginator
     * @return array
     */
    public function paginator(PaginatorInterface $paginator)
    {
        $pagination = parent::paginator($paginator)['pagination'];

        return [
            'pagination' => [
                'total' => $pagination['total'],
                'count' => $pagination['count'],
                'perPage' => $pagination['per_page'],
                'currentPage' => $pagination['current_page'],
                'totalPages' => $pagination['total_pages'],
                'links' => $pagination['links'],
            ],
        ];
    }

    /**
     * Format cursor data.
     *
     * @param  \League\Fractal\Pagination\CursorInterface $cursor
     * @return array
     */
    public function cursor(CursorInterface $cursor)
    {
        return [
            'cursor' => [
                'current' => $cursor->getCurrent(),
                'previous' => $cursor->getPrev(),
                'next' => $cursor->getNext(),
                'count' => (int) $cursor->getCount(),
            ],
        ];
    }

    /**
     * Indicates if includes should be side-loaded.
     *
     * @return bool
     */
    public function sideloadIncludes()
    {
        return true;
    }

    /**
     * Merge includes into data.
     *
     * @param  array $transformedData
     * @param  array $includedData
     * @return array
     */
    public function mergeIncludes($transformedData, $includedData)
    {
        foreach (array_keys($includedData) as $key) {
            $includedData[$key] = $includedData[$key]['data'];
        }

        return array_merge($transformedData, $includedData);
    }

    /**
     * Format the included data.
     *
     * @param  \League\Fractal\Resource\ResourceInterface $resource
     * @param  array                                      $data
     * @return array
     */
    public function includedData(ResourceInterface $resource, array $data)
    {
        return [];
    }
}
