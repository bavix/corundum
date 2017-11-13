<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Bavix\App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConfigController extends Controller
{

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param Request $request
     * @param         $id
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function destroy(Request $request, $id)
    {
        $config = Config::query()->find($id);
        abort_if(!$config, 404);

        if ($config->delete()) {
            return response('', 204);
        }

        return abort(500);
    }

    public function store(Request $request)
    {
        $id = $request->input('id');

        if ($id)
        {
            $config = Config::query()->find($id);
        }

        $object = $config ?? new Config();
        $user   = $request->user();

        $object->user_id = $user->id;
        $object->name    = $request->input('name');
        $object->type    = $request->input('type');
        $object->width   = $request->input('width');
        $object->height  = $request->input('height');
        $object->color   = $request->input('color');
        $object->quality = $request->input('quality');

        $object->save();

        return redirect(route('ux.config.index'));
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view('config.index', [
            'user' => $request->user(),
            'item' => null
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('config.index', [
            'user' => $request->user()
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, $id)
    {
        return view('config.index', [
            'user' => $request->user(),
            'item' => Config::query()->find($id)
        ]);
    }

}
