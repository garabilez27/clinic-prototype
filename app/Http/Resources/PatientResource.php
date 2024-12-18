<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => md5($this->ptt_id),
            'firstname' => $this->ptt_fname,
            'lastname' => $this->ptt_lname,
            'email' => $this->ptt_email,
            'phone' => $this->ptt_phone,
            'active' => $this->ptt_active,
            'image' => asset($this->ptt_image),
        ];
    }
}
