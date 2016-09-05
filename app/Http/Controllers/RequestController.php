<?php

namespace App\Http\Controllers;

use App\Services\RequestService;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Auth;
use App\Http\Requests\EditRequest;

class RequestController extends Controller
{

    use Helpers;

    /**
     * @var RequestService
     */
    private $_requestService;


    /**
     *
     */
    function __construct()
    {
        $this->_requestService = new RequestService();
        // TODO: Implement __construct() method.
    }

    /**
     * @return User
     */
    private function getUser()
    {
        return $this->auth->user();
    }

    /**
     * @return \App\Company
     */
    private function getCompany()
    {
        return $this->getUser()->company;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        var_dump($this->getUser());die;
        return $this->_requestService->getItems($this->getCompany()->id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EditRequest $request)
    {
        $this->_requestService->createItem($request, $this->getCompany()->id);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditRequest $request, $id)
    {
        $this->_requestService->editItem($id, $request, $this->getCompany()->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->_requestService->deleteItem($id, $this->getCompany()->id);
    }
}
