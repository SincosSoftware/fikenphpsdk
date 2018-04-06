<?php

namespace FikenSDK\Clients;

class Companies extends ResourceClient
{
    const REL = 'companies';

    public function all()
    {
        $companies = $this->getCompanies();

        return array_map(function ($company) {
            return [
                'companyName' => $company->name,
                'companyNumber' => $company->organizationNumber,
                'companySlug' => $company->slug,
            ];
        }, $companies);
    }

    protected function getResourceName()
    {
        return self::REL;
    }
}