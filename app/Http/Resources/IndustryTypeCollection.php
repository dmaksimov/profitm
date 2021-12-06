<?php

namespace App\Http\Resources;

use App\Models\IndustryType;
use Illuminate\Http\Resources\Json\ResourceCollection;

class IndustryTypeCollection extends ResourceCollection
{
    public $collects = IndustryType::class;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'links' => [
                'self' => 'link-value',
            ]
        ];
    }
}
