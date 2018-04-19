<?php

namespace App\Behat;

use Behat\Behat\Context\Context;
use Geo\Entity\CityEntity;
use Geo\Entity\CountryEntity;
use Mockery\MockInterface;
use Organization\Entity\OrganizationEntity;
use User\Entity\UserEntity;
use Webmozart\Assert\Assert;

class DomainContext implements Context
{
    /** @var UserEntity|MockInterface */
    private $user;
    /** @var OrganizationEntity */
    private $organization;

    /**
     * @Given I'am logged in as :user
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function iamLoggedInAs(string $user)
    {
        $this->user = \Mockery::mock(UserEntity::class);
    }

    /**
     * @When I create :orgName organization with description :orgDescription in :cityName, :countryName
     */
    public function iCreateOrganizationWithDescription(
        string $orgName,
        string $orgDescription,
        string $cityName,
        string $countryName
    ) {
        $country = new CountryEntity('XX', $countryName);
        $city    = new CityEntity($cityName, $country);

        $this->organization = new OrganizationEntity($orgName, $orgDescription, $this->user, $city);
    }

    /**
     * @Then there is new :orgName organization
     */
    public function thereIsNewOrganization(string $orgName)
    {
        Assert::eq($orgName, $this->organization->getTitle());
    }

    /**
     * @Then :user is founder of :orgName organization
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function isFounderOfOrganization(string $user, string $orgName)
    {
        Assert::eq($this->user, $this->organization->getFounder());
    }
}
