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
     */
    public function iamLoggedInAs()
    {
        $this->user = \Mockery::mock(UserEntity::class);
    }

    /**
     * @Given someone just created :orgName organization
     */
    public function someoneJustCreatedOrganization(string $orgName)
    {
        $this->organization = new OrganizationEntity(
            $orgName, 'A description', \Mockery::mock(UserEntity::class), \Mockery::mock(CityEntity::class)
        );
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
     * @When I approve :orgName organization
     */
    public function iApproveOrganization()
    {
        $this->organization->approve();
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
     */
    public function isFounderOfOrganization()
    {
        Assert::eq($this->user, $this->organization->getFounder());
    }

    /**
     * @Then :orgName organization is approved
     */
    public function organizationIsApproved()
    {
        Assert::true($this->organization->isApproved());
    }
}
