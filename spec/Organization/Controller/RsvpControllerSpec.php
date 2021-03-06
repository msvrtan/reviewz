<?php

declare(strict_types=1);

namespace spec\Organization\Controller;

use Doctrine\ORM\EntityManager;
use DomainException;
use Event\Entity\EventEntity;
use Organization\Controller\RsvpController;
use Organization\Entity\OrganizationEntity;
use PhpSpec\ObjectBehavior;
use User\Entity\UserEntity;

class RsvpControllerSpec extends ObjectBehavior
{
    public function let(EntityManager $entityManager, UserEntity $currentUser)
    {
        $this->beConstructedWith($entityManager, $currentUser);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(RsvpController::class);
    }

    public function it_will_add_member_to_attendee_list_when_they_rsvp_yes(
        EventEntity $meetup,
        EntityManager $entityManager,
        UserEntity $currentUser,
        OrganizationEntity $organization
    ) {
        $meetup->getOrganization()->shouldBeCalled()->willReturn($organization);
        $organization->isMember($currentUser)->shouldBeCalled()->willReturn(true);

        $meetup->addAttendee($currentUser)
            ->shouldBeCalled();

        $entityManager->persist($meetup)->shouldBeCalled();
        $entityManager->flush()->shouldBeCalled();

        $this->rsvpYes($meetup);
    }

    public function it_will_not_allow_non_members_to_rsvp_yes(
        EventEntity $meetup,
        UserEntity $currentUser,
        OrganizationEntity $organization
    ) {
        $meetup->getOrganization()->shouldBeCalled()->willReturn($organization);
        $organization->isMember($currentUser)->shouldBeCalled()->willReturn(false);

        $this->shouldThrow(DomainException::class)->duringRsvpYes($meetup);
    }

    public function it_will_add_member_to_not_coming_list_when_they_rsvp_no(
        EventEntity $meetup,
        EntityManager $entityManager,
        UserEntity $currentUser,
        OrganizationEntity $organization
    ) {
        $meetup->getOrganization()->shouldBeCalled()->willReturn($organization);
        $organization->isMember($currentUser)->shouldBeCalled()->willReturn(true);

        $meetup->addNotComing($currentUser)
            ->shouldBeCalled();

        $entityManager->persist($meetup)->shouldBeCalled();
        $entityManager->flush()->shouldBeCalled();

        $this->rsvpNo($meetup);
    }

    public function it_will_not_allow_non_members_to_rsvp_no(
        EventEntity $meetup,
        UserEntity $currentUser,
        OrganizationEntity $organization
    ) {
        $meetup->getOrganization()->shouldBeCalled()->willReturn($organization);
        $organization->isMember($currentUser)->shouldBeCalled()->willReturn(false);

        $this->shouldThrow(DomainException::class)->duringRsvpNo($meetup);
    }

    public function it_will_add_member_to_maybe_coming_list_when_they_rsvp_maybe(
        EventEntity $meetup,
        EntityManager $entityManager,
        UserEntity $currentUser,
        OrganizationEntity $organization
    ) {
        $meetup->getOrganization()->shouldBeCalled()->willReturn($organization);
        $organization->isMember($currentUser)->shouldBeCalled()->willReturn(true);

        $meetup->addMaybeComing($currentUser)
            ->shouldBeCalled();

        $entityManager->persist($meetup)->shouldBeCalled();
        $entityManager->flush()->shouldBeCalled();

        $this->rsvpMaybe($meetup);
    }

    public function it_will_not_allow_non_members_to_rsvp_maybe(
        EventEntity $meetup,
        UserEntity $currentUser,
        OrganizationEntity $organization
    ) {
        $meetup->getOrganization()->shouldBeCalled()->willReturn($organization);
        $organization->isMember($currentUser)->shouldBeCalled()->willReturn(false);

        $this->shouldThrow(DomainException::class)->duringRsvpMaybe($meetup);
    }
}
