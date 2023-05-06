<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\CreditRequest;
use App\Http\Resources\Api\V1\CreditResource;
use App\Services\CreditOfferService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CreditController extends Controller
{
    private $creditOfferService;

    /**
     * This is a constructor function that injects a CreditOfferService object into the class.
     * 
     * @param CreditOfferService creditOfferService The parameter `` is an instance of
     * the `CreditOfferService` class, which is likely a service or repository class responsible for
     * handling credit offers in the application. The `__construct` method is using dependency injection to
     * inject an instance of this class into the current class, allowing it
     */
    public function __construct(CreditOfferService $creditOfferService)
    {
        $this->creditOfferService = $creditOfferService;
    }

    /**
     * This function returns an anonymous resource collection for a credit offer request handled by a
     * credit offer service.
     * 
     * @param CreditRequest request  is an instance of the CreditRequest class, which is being
     * passed as an argument to the creditOffer method. The method is using this request object to call
     * the handle method of the creditOfferService object. The handle method is responsible for
     * processing the credit request and returning an anonymous resource collection.
     * 
     * @return AnonymousResourceCollection An AnonymousResourceCollection is being returned.
     */
    public function creditOffer(CreditRequest $request): AnonymousResourceCollection|JsonResponse
    {
        $bestCreditDeals = $this->creditOfferService->handle($request);

        if (is_string($bestCreditDeals)) {
            return response()->json([
                'message' => 'Internal server error.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return CreditResource::collection($bestCreditDeals);
    }
}
