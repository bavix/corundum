<?php

namespace App\Http\Api;

use Illuminate\Database\Eloquent\Builder;
use App\Models\User;

class FileController extends BaseController
{

    /**
     * @return Builder
     */
    protected function query(): Builder
    {
        /**
         * @var $user User
         */
        $user = \auth()->user();
        return $user->files()->getQuery();
    }

}
