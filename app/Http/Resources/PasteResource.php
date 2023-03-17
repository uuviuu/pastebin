<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PasteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'created_by_id' => $this->created_by_id,
            'expiration_time' => $this->expiration_time,
            'access' => $this->access,
            'hash' => $this->hash,
            'locale_lang' => $this->locale_lang,
            'paste' => $this->paste,
        ];
    }
}
