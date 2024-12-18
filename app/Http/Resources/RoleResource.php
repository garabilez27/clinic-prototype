<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => md5($this->rl_id),
            'detail' => $this->rl_detail,
            'level' => $this->rl_level,
            'active' => $this->rl_active,
        ];
    }
}
