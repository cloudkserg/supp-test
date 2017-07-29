<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 06.09.16
 * Time: 14:19
 */

namespace App\Transformers;


use App\Message;
use League\Fractal\TransformerAbstract;
use Swagger\Annotations as SWG;

/**
 *
 * @SWG\Definition(
 *      type="object",
 *      definition="MessageModel",
 *      @SWG\Property(
 *          property="id",
 *          type="integer"
 *      ),
 *      @SWG\Property(
 *          property="text",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="status",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="created",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="readed",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="from_company_id",
 *          type="integer"
 *      ),
 *      @SWG\Property(
 *          property="to_company_id",
 *          type="integer"
 *      ),
 *      @SWG\Property(
 *          property="demand_id",
 *          type="integer"
 *      ),
 * )
 * Class MessageTransformer
 * @package App\Transformers
 */
class MessageTransformer extends TransformerAbstract
{

    public function transform(Message $message)
    {
        return [
            'id' => (int)$message->id,
            'demand_id' => (int)$message->demand_id,
            'from_company_id' => (int)$message->to_company_id,
            'to_company_id' => (int)$message->from_company_id,
            'status' => $message->status,
            'created' => $message->created_at->toDateTimeString(),
            'readed' => (!empty($message->readed_time) ? $message->readed_time->toDateTimeString() : null),
            'text' => $message->text
        ];
    }

}
