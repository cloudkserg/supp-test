<?php

namespace App\Http\Controllers;

use App\Services\MessageService;
use Dingo\Api\Routing\Helpers;

use App\User;
use App\Company;
use App\Http\Requests;
use App\Transformers\MessageTransformer;
use Swagger\Annotations as SWG;

class MessagesController extends Controller
{

    use Helpers;

    /**
     * @var MessageService
     */
    private $messageService;


    /**
     * @param MessageService $messageService
     */
    function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    /**
     * @return User
     */
    private function getUser()
    {
        return $this->auth->user();
    }

    /**
     * @return Company
     */
    private function getCompany()
    {
        return $this->getUser()->company;
    }

    /**
     * @SWG\Get(
     *     path="/messages",
     *     summary="Get my messages",
     *     tags={"message"},
     *     description="",
     *     operationId="getMessages",
     *      @SWG\Parameter(
     *         name="demandId",
     *         in="query",
     *         type="integer",
     *         description="demand_id"
     *      ),
     *      @SWG\Parameter(
     *         name="status",
     *         in="query",
     *         type="string",
     *         enum={"active","archived"},
     *         description="filtered Status [or array of status]"
     *      ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref="#/definitions/MessageModel")
     *          )
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
    /**
     * Display a listing of the resource.
     *
     * @param Requests\IndexMessagesRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(Requests\IndexMessagesRequest $request)
    {
        $items = $this->messageService->getItemsByDemandAndStatus(
            $this->getCompany()->id, $request->getStatus(), $request->demandId
        );
        return $this->response->collection(
            $items,
            (new MessageTransformer())
        );

    }

    /**
     * @SWG\Post(
     *     path="/messages",
     *     summary="Create message",
     *     tags={"message"},
     *     description="",
     *     operationId="createMessages",
     *     @SWG\Parameter(
     *          name="Message",
     *          in="body",
     *          @SWG\Schema(ref="#/definitions/CreateMessageRequest")
     *      ),
     *     @SWG\Response(
     *         response=201,
     *         description="successful operation",
     *         @SWG\Header(header="location", type="string", description="/messages/1")
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
    public function store(Requests\CreateMessageRequest $createRequest)
    {
        $message = $this->messageService->createMessage(
            $this->getCompany(), $createRequest->getDemand(),
            $createRequest->toCompanyId, $createRequest->text
        );

        return $this->response->created('/messages/' . $message->id);
    }

    /**
     * @SWG\Post(
     *     path="/messages/{id}/readed",
     *     summary="Update readed message",
     *     tags={"message"},
     *     description="",
     *     operationId="updateReadedMessage",
     *     @SWG\Parameter(name="id", in="path", required=true, type="integer"),
     *     @SWG\Parameter(
     *          name="Message",
     *          in="body",
     *          @SWG\Schema(ref="#/definitions/CreateReadedMessageRequest")
     *      ),
     *     @SWG\Response(
     *         response=202,
     *         description="successful operation",
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
    public function updateReaded(Requests\CreateReadedMessageRequest $request)
    {
        $unChangeMessage = $request->getMessage();
        $response = $this->messageService->setReadedItem($unChangeMessage, $request->getReaded());
        return $this->response->accepted();

    }

}
