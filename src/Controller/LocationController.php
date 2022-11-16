<?php

namespace App\Controller;

use App\Entity\Location;
use App\Form\Type\LocationType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/api/v1", name="_api")
 */
class LocationController extends AbstractApiController
{
    /**
     * @Route("/locations", name="locations_list", methods={"GET"})
     */
    public function indexAction(Request $request): Response
    {
        $locations = $this->getDoctrine()->getRepository(Location::class)->findAll();

        return $this->json($locations);
    }

    /**
     * @Route("/locations/create", name="locations_create", methods={"POST"})
     */
    public function createAction(Request $request): Response
    {
       $form = $this->buildForm(LocationType::class);

       $form->handleRequest($request);

       /** @var Location $location */
       $location = $form->getData();

       print($this->json($location));
       exit();

       $this->getDoctrine()->getManager()->persist($location);
       $this->getDoctrine()->getManager()->flush();

       return $this->json('');
    }

    /**
     * @Route("/locations/show/{id}", name="location_show", methods={"GET"})
     */
    public function show(int $id): Response
    {
        $location = $this->getDoctrine()->getRepository(Location::class)->find($id);

        if (!$location)
        {
            return $this->json('No customer with this id ' . $id, 404 );
        }

        $data = [
            'id' => $location->getId(),
            'name' => $location->getName(),
        ];

        return $this->json($data);
    }

    /**
     * @Route("/locations/edit/{id}", name="location_edit", methods={"PUT"})
     */
    public function edit(Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $location = $this->getDoctrine()->getRepository(Location::class)->find($id);

        if (!$location)
        {
            return $this->json('No customer with this id ' . $id, 404 );
        }

        $location->setName($request->request->get('name'));
        $entityManager->flush();

        $data = [
            'name' => $location->getName(),
        ];

        return $this->json($data);
    }


    /**
     * @Route("/locations/delete/{id}", name="location_delete", methods={"DELETE"})
     */
    public function delete(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $location = $this->getDoctrine()->getRepository(Location::class)->find($id);

        if(!$location)
        {
            return $this->json("Location was not found with id " . $id, 400);
        }

        $entityManager->remove($location);
        $entityManager->flush();

        return $this->json("Location was removed successfully with id " . $id);
    }
}
