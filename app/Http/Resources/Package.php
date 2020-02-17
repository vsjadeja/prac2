<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Helpers\AssetHelper;
use App\Http\Resources\PackageType as PackageType;

class Package extends JsonResource
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
            "id"                => $this->id,
            "name"              => $this->name,
            "description"       => $this->description,
            "price"             => $this->price,
            "thumb"             => AssetHelper::cdn($this->thumb),
            "package_type_id"   => new PackageType($this->packageType),
            "status"            => $this->status,
        ];
    }
}
