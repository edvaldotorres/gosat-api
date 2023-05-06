<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class CreditResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'instituicaoFinanceira' => $this->name_institution,
            'modalidadeCredito' => $this->name_offer,
            'valorAPagar' => $this->value_min,
            'valorSolicitado' => $request->get('value'),
            'taxaJuros' => $this->value_fees_month,
            'qntParcelas' => $request->get('parcel'),
        ];
    }
}
