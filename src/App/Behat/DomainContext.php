<?php

namespace App\Behat;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Doctrine\ORM\EntityManager;
use Organization\Controller\ClaimController;
use Organization\Entity\ClaimEntity;
use Organization\Entity\MeetupEntity;
use Organization\Repository\ClaimRepository;
use Talk\Entity\TalkEntity;
use User\Entity\UserEntity;

class DomainContext implements Context
{
    /**
     * @var ClaimEntity
     */
    private $claim;

    /**
     * @Given speaker has claimed a talk
     */
    public function speakerHasClaimedATalk()
    {
        $meetup = new MeetupEntity();
        $talk = new TalkEntity($meetup, 'Title', 'Description', 'Jo Doe');
        $speaker = new UserEntity();
        $this->claim = new ClaimEntity($talk, $speaker);
    }

    /**
     * @When organizer approves claim
     */
    public function organizerApprovesClaim()
    {
        $organizer = new UserEntity();

        $zz = new ClaimController(
            new ClaimRepository(),
            \Mockery::mock(EntityManager::class),
            $organizer
        );

        $zz->approvePendingClaim($this->claim);
    }

    /**
     * @Then talk has a speaker set
     */
    public function talkHasASpeakerSet()
    {
        throw new PendingException();
    }

}
