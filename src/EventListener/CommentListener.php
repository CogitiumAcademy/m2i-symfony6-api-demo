<?php
namespace App\EventListener;

use App\Entity\Comment;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Symfony\Bundle\SecurityBundle\Security;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;

#[AsDoctrineListener(event: Events::prePersist, priority: 500, connection: 'default')]
class CommentListener
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    
    // the listener methods receive an argument which gives you access to
    // both the entity object of the event and the entity manager itself
    public function prePersist(PrePersistEventArgs $args): void
    {
        $entity = $args->getObject();

        // if this listener only applies to certain entity types,
        // add some code to check the entity type as early as possible

        // Si l'instance est de type Post
        if ($entity instanceof Comment) {
            // On procède à l'initialisation de l'auteur
            $user = $this->security->getUser();
            $entity->setAuthor($user);
        }
    }
}