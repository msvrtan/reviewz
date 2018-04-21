<?php

namespace App\Behat;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Geo\Entity\CityEntity;
use Geo\Entity\CountryEntity;
use Miro\CreateUser;
use Miro\CreateUserHandler;
use Mockery\MockInterface;
use Organization\Entity\OrganizationEntity;
use SimpleBus\Message\Bus\Middleware\MessageBusSupportingMiddleware;
use SimpleBus\Message\CallableResolver\CallableMap;
use SimpleBus\Message\CallableResolver\ServiceLocatorAwareCallableResolver;
use SimpleBus\Message\Handler\DelegatesToMessageHandlerMiddleware;
use SimpleBus\Message\Handler\Resolver\NameBasedMessageHandlerResolver;
use SimpleBus\Message\Name\ClassBasedNameResolver;
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
     * @When I reject :orgNamr organization
     */
    public function iRejectOrganization()
    {
        $this->organization->reject();
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

    /**
     * @Then :orgName organization is rejected
     */
    public function organizationIsRejected()
    {
        Assert::false($this->organization->isApproved());
    }

    /**
     * @Given there is new :orgName organization with :numberOfMembers members
     */
    public function thereIsNewOrganizationWithMembers($arg1, $arg2)
    {
        $commandBus = $this->getCommandBus();

        $commandBus->handle(new CreateUser());

        throw new PendingException();
    }

    private function getCommandBus()
    {
        $commandBus = new MessageBusSupportingMiddleware();

        $commandHandlersByCommandName = [
            CreateUser::class => CreateUserHandler::class,
        ];

        $serviceLocator = function ($serviceId) {
            return new $serviceId();
        };

        $commandHandlerMap = new CallableMap(
            $commandHandlersByCommandName,
            new ServiceLocatorAwareCallableResolver($serviceLocator)
        );

        $commandHandlerResolver = new NameBasedMessageHandlerResolver(new ClassBasedNameResolver(), $commandHandlerMap);
        $commandBus->appendMiddleware(
            new DelegatesToMessageHandlerMiddleware(
                $commandHandlerResolver
            )
        );

        return $commandBus;
    }

    /**
     * @Then :arg1 organization has no members
     */
    public function organizationHasNoMembers($arg1)
    {
        throw new PendingException();
    }
}
