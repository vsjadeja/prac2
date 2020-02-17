<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\PackageType;
use App\Http\Requests\StorePackage;
use App\Helpers\PackageHelper;
use App\Helpers\CacheHelper;
use Illuminate\Support\Facades\Cache;

use App\Http\Controllers\BaseController as BaseController;
use Validator;
use App\Http\Resources\Package as PackageResource;

class PackageController extends BaseController
{
    var $pageSize = 10;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = (request()->input('page', 1) - 1) * $this->pageSize;
        $cacheKey = CacheHelper::getKey(__CLASS__, __FUNCTION__, $page);
        
        if (Cache::has($cacheKey)):
            $packages = Cache::tags([__CLASS__])->get($cacheKey);
        else:
            $packages = Package::latest()->paginate($this->pageSize);
            Cache::tags([__CLASS__])->forever($cacheKey, $packages);
        endif;

        return $this->sendResponse(PackageResource::collection($packages), 'Packages retrieved successfully.');
    }
}
