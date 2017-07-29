<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 29.07.17
 * Time: 17:33
 */

namespace App\Services;


use App\Company;
use App\Demand\Demand;
use App\Demand\Response;
use App\Message;
use App\Queries\MessageQuery;
use App\Repository\MessageRepository;
use App\Type\MessageStatus;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MessageService
{

    const MAX_MESSAGES = 100;

    /**
     * @var MessageRepository
     */
    private $repository;

    public function __construct(MessageRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * @param Demand $demand
     * @param $toCompanyId
     * @return bool
     */
    private function checkToCompanyId(Demand $demand, $toCompanyId)
    {
        if ($demand->company_id == $toCompanyId) {
            return true;
        }
        return collect($demand->responses)->filter(function (Response $response) use ($toCompanyId) {
            return $response->company_id == $toCompanyId;
        })->isNotEmpty();
    }

    /**
     * @param Company $company
     * @param Demand $demand
     * @param $toCompanyId
     * @param $text
     * @return Message
     */
    public function createMessage(Company $company, Demand $demand, $toCompanyId, $text)
    {
        if (!$this->checkToCompanyId($demand, $toCompanyId)) {
            throw new NotFoundHttpException('Компания которой отправляете сообщение нет в этом запросе');
        }

        $item = new Message();
        $item->from_company_id = $company->id;
        $item->to_company_id = $toCompanyId;
        $item->demand_id = $demand->id;
        $item->text = $text;
        $item->status = MessageStatus::ACTIVE;
        $item->saveOrFail();
        return $item;
    }


    /**
     * @param $companyId
     * @param $status
     * @param null $demandId
     * @return Message[]
     */
    public function getItemsByDemandAndStatus($companyId, $status, $demandId = null)
    {
        $query = new MessageQuery();
        $query->forStatus($status);
        $query->forCompany($companyId);
        if (isset($demandId)) {
            $query->forDemand($demandId);
        }

        return $this->repository->findAll($query->getBuilder(), self::MAX_MESSAGES);
    }

}