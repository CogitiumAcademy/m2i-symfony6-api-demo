<?php

namespace App\Security\Voter;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class UserVoter extends Voter
{
    public const READ = 'user_read';
    public const EDIT = 'user_edit';
    
    public function __construct(private Security $security)
    {
    }
    
    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        //dd($subject);
        return in_array($attribute, [self::READ, self::EDIT])
            /*&& $subject instanceof \App\Entity\User*/;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $userToken = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$userToken instanceof UserInterface) {
            return false;
        }

        $user = $subject;

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::READ:
                // ROLE_USER ?
                //dd("ICI !");
                return $this->security->isGranted('ROLE_USER');
                break;

            case self::EDIT:
                // User modifié = User du token ?
                return 
                    $user == $userToken;
                break;
        }

        return false;
    }
}
