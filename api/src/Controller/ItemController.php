<?php

namespace App\Controller;

use App\Entity\Item;
use App\Repository\ItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ItemController extends AbstractController
{
    /**
     * @Route("/items/",
     *  name="api_item_displayAll", methods={"GET"})
     */
    public function displayAll(ItemRepository $repo): Response
    {
        return $this->json($repo->findAll());
    }
    /**
     * @Route("/items/", name="api_item_add", methods={"POST"})
     */
    public function addItem(Request $request, EntityManagerInterface $em)
    {
        // objet json item
       $item = json_decode($request->getContent());

       $newItem = new Item();
       $newItem->setName($item->name);
       $newItem->setBuy(false);

       $em->persist($newItem);
       $em->flush();

       $tab["message"] = "Hello Ajouter ! " . $item->name;
       return $this->json($tab);
    }
    /**
     * @Route("/items/{id}", name="api_item_remove", methods={"DELETE"})
     */
    public function removeItem(Item $item, EntityManagerInterface $em)
    {
        $em->remove($item);
        $em->flush();
        $tab["message"] = "supprimer";
        return $this->json($tab);
    }
    /**
     * @Route("/items/{id}", name="api_item_update", methods={"PUT"})
     */
    public function updateItem(Request $request, Item $item, EntityManagerInterface $em)
    {
        $i = json_decode($request->getContent());

        $item->setName($i->name);
        $item->setBuy($i->buy);

        $em->persist($item);
        $em->flush();

        $tab["message"] = "updater";
        return $this->json($tab);
    }
}
