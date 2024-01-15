<?php
namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MeController extends AbstractController
{
    public function __invoke(): User
    {
        $user = $this->getUser();
        $user->setPassword('');
        return $user;
    }
}