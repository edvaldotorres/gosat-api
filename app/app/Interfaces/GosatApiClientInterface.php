<?php

namespace App\Interfaces;

interface GosatApiClientInterface
{
    public function getInstitutionCreditOffer(string $cpf): array;

    public function getDetailsCreditOffer(string $cpf, int $institution_id, string $code): array;
}
