<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 01.09.16
 * Time: 16:39
 */

namespace App\Services;



use App\Demand\ResponseItem;
use App\Type\InvoiceStatus;
use App\Demand\Invoice;
use Illuminate\Http\UploadedFile;
use App\Events\Invoice\CreateInvoiceEvent;
use App\Events\Invoice\DeleteInvoiceEvent;
use App\Events\Invoice\ResponsedInvoiceEvent;
use Illuminate\Database\Eloquent\Collection;

class InvoiceService
{

    /**
     * @var ResponseItemService
     */
    private $responseItemService;

    /**
     *
     */
    function __construct()
    {
        $this->responseItemService = new ResponseItemService();
    }


    /**
     * @param Collection $responseItems
     * @return Invoice|null
     */
    public function createItem(Collection $responseItems)
    {
        if (empty($responseItems)) {
            return null;
        }
        $response = $responseItems[0]->response;

        $invoice = $this->create($response->id);
        $this->attachResponseItems($responseItems, $invoice->id);

        event(new CreateInvoiceEvent($invoice));

        return $invoice;
    }

    /**
     * @param Invoice $item
     * @throws \Exception
     */
    public function deleteItem(Invoice $item)
    {
        if (isset($item->filename)) {
            $this->removeFile($item->filepath);
        }
        event(new DeleteInvoiceEvent($item));
        $item->delete();
    }

    /**
     * @param $id
     * @return Invoice
     */
    public function findItem($id)
    {
        return Invoice::findOrFail($id);
    }

    public function changeFile(Invoice $item, UploadedFile $file)
    {
        if (isset($item->filename)) {
            $this->removeFile($item->filepath);
        }
        $this->saveFile($file, $item->getPath());

        $this->updateChangeFields($item, $file->getFilename());
        event(new ResponsedInvoiceEvent($item));
    }

    /**
     * @param Invoice $item
     * @param $filename
     *
     */
    private function updateChangeFields(Invoice $item, $filename)
    {
        $item->filename = $filename;
        $item->status = InvoiceStatus::RESPONSED;
        $item->saveOrFail();
    }

    /**
     * @param Collection $responseItems
     * @param $invoiceId
     */
    private function attachResponseItems(Collection $responseItems, $invoiceId)
    {
        $responseItems->each(function (ResponseItem $responseItem) use ($invoiceId) {
            $this->responseItemService->setInvoice($responseItem, $invoiceId);
        });
    }


    private function saveFile(UploadedFile $file, $filepath)
    {
        $file->move($filepath);
    }


    private function removeFile($file)
    {
        \File::delete($file);
    }


    public function onDelete(Invoice $item)
    {
        event(new DeleteInvoiceEvent($item));
    }

    public function onUpdate(Invoice $item)
    {
        if ($item->isDirty('status') and $item->status == InvoiceStatus::RESPONSED) {
            event(new ResponsedInvoiceEvent($item));
        }
    }

    private function create($responseId)
    {
        $item = new Invoice();
        $item->response_id = $responseId;
        $item->status = InvoiceStatus::REQUESTED;
        $item->saveOrFail();
        return $item;
    }

}