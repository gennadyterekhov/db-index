<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use App\Entity\User;
use App\Repository\UserEmailBTreeRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    public function __construct(
        private UserRepository $userRepository,
        private UserEmailBTreeRepository $userEmailBTreeRepository,
    ) {}

    #[Route('/')]
    public function main(): Response
    {
        $number = random_int(0, 100);

        $allUsers = $this->userRepository->findAll();
        $allUsersEmailBtree = $this->userEmailBTreeRepository->findAll();
        $allUsers = array_map(static fn(User $u) => $u->__toArray(), $allUsers);

        $dt = json_encode($allUsers);
        return new Response(
            '<html><body>Lucky number: ' . $number . " <pre>$dt</pre></body></html>"
        );
    }
}