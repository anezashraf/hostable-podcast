<?php
/**
 * Created by IntelliJ IDEA.
 * User: testaccount123
 * Date: 12/03/19
 * Time: 18:58
 */

namespace App\UserManagement;

use App\Entity\InvitationLink;
use App\Entity\User;
use App\Repository\InvitationLinkRepository;
use App\Repository\UserRepository;
use Exception;
use Symfony\Component\Routing\RouterInterface;

class UserCreator
{
    private $invitationLinkRepo;
    private $userRepository;
    private $router;
    private $host;

    public function __construct(
        UserRepository $userRepository,
        InvitationLinkRepository $invitationLinkRepos,
        RouterInterface $router,
        string $host
    ) {
        $this->userRepository = $userRepository;
        $this->invitationLinkRepo = $invitationLinkRepos;
        $this->router = $router;
        $this->host = $host;
    }

    public function initNewInvitationLink()
    {
        $bytes = openssl_random_pseudo_bytes(48);

        if (! $bytes) {
            throw new Exception("Failed to create invitation link");
        }

        $link = bin2hex($bytes);

        $this->invitationLinkRepo->addInvitationLink($link);


        return $this->host . $this->router->generate('users_register', ['invitationLink' => $link]);
    }

    public function resolveInvitationLink(string $invitationLink)
    {
        return $this->invitationLinkRepo->get($invitationLink);
    }

    public function createUser(User $user, InvitationLink $invitationLink)
    {
        $user->setRoles(['ROLE_ADMIN']);
        $user->setEnabled(true);
        $invitationLink->setUser($user);
        $invitationLink->setUsed(true);

        $this->invitationLinkRepo->insert($invitationLink);
        $this->userRepository->insert($user);

        return $user;
    }
}
