<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $date = Carbon::now();
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'online' => (is_null($this->last_check_at) ? false : $date->diffInSeconds(Carbon::parse($this->last_check_at)) < 60),
            'profile_picture' => $this->profile_picture,
        ];
    }
}
