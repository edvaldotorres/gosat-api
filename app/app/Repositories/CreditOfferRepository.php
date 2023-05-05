<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\CreditOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CreditOfferRepository extends AbstractRepository
{
    protected static $model = CreditOffer::class;

    /**
     * This function finds a credit offer by the client's CPF (Brazilian identification number).
     * 
     * @param string cpf The parameter "cpf" is a string representing the CPF (Cadastro de Pessoas Físicas)
     * of a client. CPF is a unique identification number assigned to Brazilian citizens and residents for
     * tax and administrative purposes.
     * 
     * @return CreditOffer|null The method `findByCpf` is returning a `CreditOffer` object or `null` if no
     * record is found in the database with the given CPF (Brazilian individual taxpayer registry
     * identification number) of the client.
     */
    public static function findByCpf(string $cpf): CreditOffer|null
    {
        return self::loadModel()::query()->where('cpf_client', $cpf)->first();
    }

    /**
     * The function returns a collection of credit offers based on the given request parameters.
     * 
     * @param Request request  is an instance of the Request class, which is used to retrieve data
     * from HTTP requests in Laravel. It is likely being used to retrieve the user's input data, such as
     * their CPF (Brazilian ID number), desired loan value, and number of installments.
     * 
     * @return Collection A collection of credit offers that match the criteria specified in the query. The
     * query searches for credit offers that have a CPF client matching the one provided in the request, a
     * value range that includes the value provided in the request, a parcel range that includes the parcel
     * quantity provided in the request, and orders the results by the value of fees per month in ascending
     * order. The function returns the top 3
     */
    public static function creditOffercalculation(Request $request): Collection
    {
        return self::loadModel()::query()
            ->where('cpf_client', $request->cpf)
            ->where('value_min', '<=', $request->get('value'))
            ->where('value_max', '>=', $request->get('value'))
            ->where('qnt_parcels_min', '<=', $request->get('parcel'))
            ->where('qnt_parcels_max', '>=', $request->get('parcel'))
            ->orderBy('value_fees_month', 'asc')
            ->limit(3)
            ->get();
    }
}
