<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Compound;
use App\Traits\BaseApiResponse;
use Illuminate\Http\Request;

class CompoundController extends Controller
{
    use BaseApiResponse;
    //index
    public function index(Request $request)
    {
        try {
            $perPage = $request->query('per_page', env('PAGINATION_PER_PAGE', 10));
            $compounds = Compound::paginate($perPage);
            info('Compounds fetched successfully : ', $compounds);
            return $this->success($compounds);
        } catch (\Exception $e) {
            return $this->failed(null, 'Error', $e->getMessage());
        }
    }
}
