<?php

namespace App\Http\Controllers;

use App\Services\ResponseItemService;
use App\Services\InvoiceService;
use Dingo\Api\Routing\Helpers;

use App\Company;
use App\Http\Requests;
use App\Http\Requests\CreateInvoiceRequest;



class InvoicesController extends Controller
{

    use Helpers;

    /**
     * @var InvoiceService
     */
    private $invoiceService;

    /**
     * @var ResponseItemService
     */
    private $responseItemService;


    /**
     *
     */
    function __construct()
    {
        $this->invoiceService = new InvoiceService();
        $this->responseItemService = new ResponseItemService();
    }




    public function store(CreateInvoiceRequest $createRequest)
    {
        $invoice = $this->invoiceService->addItem($createRequest->getResponseItemModels()[0]->response->id);
        $this->responseItemService->addInvoice($invoice, $createRequest->getResponseItemModels());

        return $this->response->created('/invoices/' . $invoice->id);
    }


    public function delete(Requests\UpdateInvoiceRequest $request)
    {
        $this->invoiceService->deleteItem($request->getInvoice());
        return $this->response->accepted();
    }

    public function file(Requests\UpdateInvoiceRequest $request)
    {
        return response()->download($request->getInvoice()->filepath);
    }

    public function update(Requests\UpdateInvoiceRequest $request)
    {
        $invoice = $request->getInvoice();
        $this->invoiceService->changeFile($invoice, $request->file);
        return $this->response()->accepted();
    }

}
