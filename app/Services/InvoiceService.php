<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 01.09.16
 * Time: 16:39
 */

namespace App\Services;



use App\Type\InvoiceStatus;
use App\Demand\Invoice;
use Illuminate\Http\UploadedFile;

class InvoiceService
{




    /**
     * @param int $responseId
     * @return Invoice
     */
    public function addItem($responseId)
    {
        $item = new Invoice();
        $item->response_id = $responseId;
        $item->status = InvoiceStatus::REQUESTED;
        $item->saveOrFail();
        return $item;
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

        $item->filename = $file->getFilename();
        $item->saveOrFail();
    }


    private function saveFile(UploadedFile $file, $filepath)
    {
        $file->move($filepath);
    }


    private function removeFile($file)
    {
        \File::delete($file);
    }


}