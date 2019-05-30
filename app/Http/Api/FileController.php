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
        return $this->getUser()
            ->files()
            ->getQuery();
    }

}
