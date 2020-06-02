<?php

namespace App\Http\Controllers;

use App\Services\DataService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Class IndexController
 * @package App\Http\Controllers
 */
class IndexController extends Controller
{
    /**
     * @var DataService
     */
    protected $service;

    /**
     * IndexController constructor.
     * @param DataService $service
     */
    public function __construct(DataService $service)
    {
        $this->service = $service;
    }

    /**
     * @param string $uid
     * @return \Illuminate\View\View
     */
    public function show(string $uid)
    {
        $data = $this->service->getById($uid);
        if (empty($data['result'])) {
            abort(404);
        }

        return view('show', [
            'data' => $data['result']
        ]);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'     => 'required|string',
            'page_uid' => 'required|string',
            'amount'   => 'required|integer',
            'currency' => [
                'required',
                Rule::in(['USD', 'EUR', 'RUR', 'CHF'])
            ]
        ]);

        $response = $this->service->store(
            $request->only(['name', 'page_uid', 'amount', 'currency'])
        );

        if (!empty($response['error'])) {
            return
                redirect()
                    ->back()
                    ->withErrors($response['error']);
        }

        return
            redirect()
                ->route('show', ['uid' => $response['result']['page_uid']]);
    }
}
