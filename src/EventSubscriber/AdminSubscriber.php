<?php

namespace App\EventSubscriber;

use App\Model\StampInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


class AdminSubscriber implements EventSubscriberInterface
{
    //Methode persister
    public static function getSubscribedEvents(): array
    {
        return[
            BeforeEntityPersistedEvent::class => ['setEntityCreatedAt'],
            BeforeEntityUpdatedEvent::class => ['setEntityUpdatedAt']
        ];
    }

    public function setEntityCreatedAt(BeforeEntityPersistedEvent $event): void
    {
        //ici le un moyen de récupérer mon Entity, ici ça va marcher pour chaque Entity de mon backend,
        //meme s'il ne dispose pas de la propiété CreatedAt.
        $entity = $event->getEntityInstance();

        if (!$entity instanceof StampInterface) {
            return;
        }
        $entity->setCreatedAt(new \DateTime());
    }

    public function setEntityUpdatedAt(BeforeEntityUpdatedEvent $event): void
    {
        //ici le un moyen de récupérer mon Entity, ici ça va marcher pour chaque Entity de mon backend,
        //meme s'il ne dispose pas de la propiété CreatedAt.
        $entity = $event->getEntityInstance();

        if (!$entity instanceof StampInterface){
            return;
        }
        $entity->setUpdatedAt(new \DateTime());
    }
}