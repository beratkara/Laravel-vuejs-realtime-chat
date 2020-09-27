<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingsResource extends JsonResource
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
            'email' => $this->email,
            'date' => $date->format('d-m-Y'),
            'time' => $date->format('H:i'),
            'last_login' => $date->format('d-m-Y H:i:s'),
            'online' => (is_null($this->last_check_at) ? false : $date->diffInSeconds(Carbon::parse($this->last_check_at)) < 60),
            'profile_picture' => $this->profile_picture,
            'profile_message' => $this->profile_message ?? 'Profil Mesajı Girilmemiş .',
            'has_role_permissions' => RolesResource::collection($this->rolesAndPermissions),
        ];
    }
}
