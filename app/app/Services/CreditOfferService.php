<?php

namespace App\Services;

use App\Http\Resources\Api\V1\CreditResource;
use App\Repositories\CreditOfferRepository;
use App\Services\Gosat\GosatApiClient;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CreditOfferService
{
    private $gosatApiClient;
    private $creditOfferRepository;

    /**
     * This is a constructor function that initializes two class properties with objects passed as
     * arguments.
     * 
     * @param GosatApiClient gosatApiClient It is an instance of the GosatApiClient class, which is likely
     * used to communicate with the Gosat API.
     * @param CreditOfferRepository creditOfferRepository The  parameter is an
     * instance of the CreditOfferRepository class, which is used to interact with the database and
     * retrieve credit offers. It is likely used within the class to fetch credit offers for processing or
     * to persist new credit offers.
     */
    public function __construct(GosatApiClient $gosatApiClient, CreditOfferRepository $creditOfferRepository)
    {
        $this->gosatApiClient = $gosatApiClient;
        $this->creditOfferRepository = $creditOfferRepository;
    }

    /**
     * This PHP function retrieves credit offers from an API, stores them in a repository, calculates the
     * best credit deals based on user input, and returns them as a collection.
     * 
     * @param Request request  is an instance of the Request class, which contains the data sent in
     * the HTTP request made to this function. It is used to retrieve the value of the "cpf" parameter sent
     * in the request.
     * 
     * @return AnonymousResourceCollection An AnonymousResourceCollection of CreditResource objects is
     * being returned.
     */
    public function handle(Request $request): AnonymousResourceCollection
    {
        $getApiInstitutionCreditOffer = $this->gosatApiClient->getInstitutionCreditOffer($request->cpf);

        foreach ($getApiInstitutionCreditOffer['instituicoes'] as $institution) {

            foreach ($institution['modalidades'] as $creditOffer) {

                $offerDetails = $this->gosatApiClient->getDetailsCreditOffer($request->cpf, $institution['id'], $creditOffer['cod']);

                $data = [
                    'name_institution' => $institution['nome'],
                    'cpf_client' => $request->cpf,
                    'name_offer' => $creditOffer['nome'],
                    'code_offer' => $creditOffer['cod'],
                    'qnt_parcels_min' => $offerDetails['QntParcelaMin'],
                    'qnt_parcels_max' => $offerDetails['QntParcelaMax'],
                    'value_min' => $offerDetails['valorMin'],
                    'value_max' => $offerDetails['valorMax'],
                    'value_fees_month' => $offerDetails['jurosMes']
                ];

                $this->creditOfferRepository->updateOrCreate([
                    'cpf_client' => $request->cpf,
                    'code_offer' => $creditOffer['cod']
                ], $data);
            }
        }

        $bestCreditDeals = $this->creditOfferRepository->creditOffercalculation($request);
        return CreditResource::collection($bestCreditDeals);
    }
}
