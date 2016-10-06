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
use Swagger\Annotations as SWG;

/**
 *
 * @SWG\Definition(
 *      definition="InvoiceModel",
 *      @SWG\Property(
 *          property="id",
 *          type="integer"
 *      ),
 *      @SWG\Property(
 *          property="status",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="response_id",
 *          type="integer"
 *      ),
 *      @SWG\Property(
 *          property="file",
 *          type="string"
 *      ),
 * )
 *
 * Class InvoiceTransformer
 * @package App\Transformers
 */
class InvoiceTransformer extends TransformerAbstract
{

    public function transform(Invoice $invoice)
    {
        return [
            'id' => (int)$invoice->id,
            'response_id' => (int)$invoice->response_id,
            'status' => $invoice->status,
            'file' => $invoice->file
        ];
    }

}
