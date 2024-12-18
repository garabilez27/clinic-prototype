<?php

namespace App\Http\Resources;

use App\Models\Menus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubMenuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => md5($this->sbmn_id),
            'detail' => $this->sbmn_detail,
            'reference' => $this->sbmn_reference,
            'icon' => $this->sbmn_icon,
            'sequence' => $this->sbmn_sequence,
            'menu' => $this->sbmn_menu,
            'class' => $this->sbmn_class,
            'for' => new MenuResource(Menus::find($this->mn_id)),
        ];
    }
}
