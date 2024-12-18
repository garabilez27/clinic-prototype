<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => md5($this->mn_id),
            'detail' => $this->mn_detail,
            'icon' => $this->mn_icon,
            'reference' => $this->mn_reference,
            'branched' => $this->mn_branched,
            'active' => $this->mn_active,
            'sequence' => $this->mn_sequence,
            'prefix' => $this->mn_prefix,
            'has_action' => $this->mn_has_actions,
        ];
    }
}
