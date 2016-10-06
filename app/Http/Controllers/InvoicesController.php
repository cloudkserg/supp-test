<?php

namespace App\Http\Controllers;

use App\Services\ResponseItemService;
use App\Services\InvoiceService;
use Dingo\Api\Routing\Helpers;

use App\Company;
use App\Http\Requests;
use App\Http\Requests\CreateInvoiceRequest;
use Swagger\Annotations as SWG;


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



    /**
     * @SWG\Post(
     *     path="/invoices",
     *     summary="Create invoice",
     *     tags={"invoice"},
     *     description="",
     *     operationId="createInvoices",
     *     @SWG\Parameter(
     *          name="Invoice",
     *          in="body",
     *          @SWG\Schema(ref="#/definitions/CreateInvoiceRequest")
     *      ),
     *     @SWG\Response(
     *         response=201,
     *         description="successful operation",
     *         @SWG\Header(header="location", type="string", description="/invoices/1")
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         ref="#/responses/NotFoundResponse"
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         ref="#/responses/NotAuthResponse"
     *     ),
     *     @SWG\Response(
     *         response="default",
     *         ref="#/responses/DefaultErrorResponse"
     *     ),
     *
     *     security={{ "token": {} }}
     * )
     */
    public function store(CreateInvoiceRequest $createRequest)
    {
        $invoice = $this->invoiceService->createItem(
            $createRequest->getResponseItemModels()
        );

        return $this->response->created('/invoices/' . $invoice->id);
    }


    /**
     * @SWG\Delete(
     *     path="/invoices/{id}",
     *     summary="Delete invoice",
     *     tags={"invoice"},
     *     description="",
     *     operationId="deleteInvoices",
     *     @SWG\Parameter(
     *          name="id",
     *          in="query",
     *          required=true,
     *          type="integer"
     *      ),
     *     @SWG\Response(
     *         response=202,
     *         description="successful operation"
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         ref="#/responses/NotFoundResponse"
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         ref="#/responses/NotAuthResponse"
     *     ),
     *     @SWG\Response(
     *         response="default",
     *         ref="#/responses/DefaultErrorResponse"
     *     ),
     *
     *     security={{ "token": {} }}
     * )
     */
    public function delete(Requests\UpdateInvoiceRequest $request)
    {
        $this->invoiceService->deleteItem($request->getInvoice());
        return $this->response->accepted();
    }

    /**
     * @SWG\Get(
     *     path="/invoices/{id}/files/{name}",
     *     summary="Download file for invoice with name",
     *     tags={"invoice"},
     *     description="",
     *     operationId="downloadInvoice",
     *     produces={"application/octet-stream", "application/json"},
     *     @SWG\Parameter(
     *          name="id",
     *          in="query",
     *          required=true,
     *          type="integer"
     *      ),
     *     @SWG\Parameter(
     *          name="name",
     *          in="query",
     *          required=true,
     *          type="string"
     *      ),
     *     @SWG\Response(
     *         response=202,
     *         description="successful operation",
     *         @SWG\Schema(type="file", description="get content of file")
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         ref="#/responses/NotFoundResponse"
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         ref="#/responses/NotAuthResponse"
     *     ),
     *     @SWG\Response(
     *         response="default",
     *         ref="#/responses/DefaultErrorResponse"
     *     ),
     *
     *     security={{ "token": {} }}
     * )
     */
    public function file(Requests\UpdateInvoiceRequest $request)
    {
        return response()->download($request->getInvoice()->filepath);
    }

    /**
     * @SWG\Put(
     *     path="/invoices/{id}",
     *     summary="Update invoice and(or) upload file",
     *     tags={"invoice"},
     *     description="",
     *     operationId="updateInvoices",
     *     @SWG\Parameter(
     *          name="id",
     *          in="query",
     *          required=true,
     *          type="integer"
     *      ),
     *     @SWG\Parameter(
     *          name="file",
     *          in="formData",
     *          required=true,
     *          type="file"
     *      ),
     *     @SWG\Response(
     *         response=202,
     *         description="successful operation"
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         ref="#/responses/NotFoundResponse"
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         ref="#/responses/NotAuthResponse"
     *     ),
     *     @SWG\Response(
     *         response="default",
     *         ref="#/responses/DefaultErrorResponse"
     *     ),
     *
     *     security={{ "token": {} }}
     * )
     */
    public function update(Requests\UpdateInvoiceRequest $request)
    {
        $invoice = $request->getInvoice();
        $this->invoiceService->changeFile($invoice, $request->file);
        return $this->response()->accepted();
    }

}
