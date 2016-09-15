<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 06.09.16
 * Time: 15:41
 */

namespace App\Transformers;

use App\Demand\Invoice;
use League\Fractal\TransformerAbstract;

class InvoiceTransformer extends TransformerAbstract
{

    public function transform(Invoice $invoice)
    {
        return [
            'id' => (int)$invoice->id,
            'status' => $invoice->status,
            'file' => $invoice->file
        ];
    }

}
