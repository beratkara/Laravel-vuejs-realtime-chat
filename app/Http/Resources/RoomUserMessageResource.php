<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomUserMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
            'message' => $this->message,
            'attachment' => $this->attachment,
            'updated_at' => $this->updated_at ? Carbon::parse($this->updated_at)->format('d-m-Y H:i:s') : '',
            'ago' => $this->updated_at->diffForHumans(),
            'user' => RoomUserResource::collection($this->users)
        ];
    }
}
