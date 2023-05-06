<?php

namespace App\Services\Gosat;

use App\Interfaces\GosatApiClientInterface;
use Illuminate\Support\Facades\Http;

class GosatApiClient implements GosatApiClientInterface
{
    private string $baseUrl;

    /**
     * This is a constructor function that sets the base URL for a specific API endpoint.
     */
    public function __construct()
    {
        $this->baseUrl = 'https://dev.gosat.org/api/v1/simulacao/';
    }

    /**
     * This PHP function retrieves credit offers from an institution based on a given CPF (Brazilian
     * individual taxpayer registry identification number).
     * 
     * @param string cpf The "cpf" parameter is a string representing the Brazilian individual taxpayer
     * registry identification number, which is similar to a social security number in the United
     * States. It is used to identify a specific individual in Brazil.
     * 
     * @return array an array containing the credit offer information for a given CPF (Brazilian
     * individual taxpayer registry identification number) from an institution's API.
     */
    public function getInstitutionCreditOffer(string $cpf): array|string
    {
        $response = Http::post($this->baseUrl . 'credito', [
            'cpf' => $cpf
        ]);

        return $response->json();
    }

    /**
     * This PHP function retrieves credit offer details by sending a POST request with specified
     * parameters and returns the response in JSON format.
     * 
     * @param string cpf The CPF (Cadastro de Pessoas Físicas) is a Brazilian individual taxpayer
     * identification number, similar to a Social Security number in the United States. It is a unique
     * identifier assigned to each Brazilian citizen or resident alien who pays taxes, and it is
     * required for many financial transactions in Brazil.
     * @param int institution_id The institution_id parameter is an integer that represents the ID of
     * the financial institution offering the credit.
     * @param string code The "code" parameter is a string that represents the code of the credit
     * offer's modality. It is used to identify the specific type of credit offer being requested.
     * 
     * @return array an array with the details of a credit offer, obtained through an HTTP POST request
     * to a specific URL with the parameters of the CPF (Brazilian individual taxpayer registry
     * identification), institution ID, and code of the credit modality. The response is expected to be
     * in JSON format.
     */
    public function getDetailsCreditOffer(string $cpf, int $institution_id, string $code): array|string
    {
        $response = Http::post($this->baseUrl . 'oferta', [
            'cpf' => $cpf,
            'instituicao_id' => $institution_id,
            'codModalidade' => $code
        ]);

        return $response->json();
    }
}
