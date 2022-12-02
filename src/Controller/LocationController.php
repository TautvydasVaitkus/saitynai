<?php

namespace App\Controller;

use App\Entity\Location;
use App\Entity\Machine;
use App\Form\Type\LocationType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


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
     * @Route("/locations", name="locations_create", methods={"POST"})
     */
    public function createAction(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $location = new Location();

        $name = $request->request->get("name");

        if ($name == "")
        {
            return $this->json("Field 'name' cannot be blank", 400);
        }

        $location->setName($request->request->get("name"));

        $this->getDoctrine()->getManager()->persist($location);
        $this->getDoctrine()->getManager()->flush();

        return $this->json($location, 201);
    }

    /**
     * @Route("/locations/{id}", name="location_show", methods={"GET"})
     */
    public function show(int $id): Response
    {
        $location = $this->getDoctrine()->getRepository(Location::class)->find($id);

        if (!$location)
        {
            return $this->json('No location with this id ' . $id, 404 );
        }

        $data = [
            'id' => $location->getId(),
            'name' => $location->getName(),
        ];

        return $this->json($data, 200);
    }

    /**
     * @Route("/locations/{id}", name="location_edit", methods={"PUT"})
     */
    public function edit(int $id,Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $location = $this->getDoctrine()->getRepository(Location::class)->find($id);

        if (!$location)
        {
            return $this->json('No location with this id ' . $id, 404 );
        }

        $name = $request->request->get("name");

        if($name == "") {
            return $this->json("Field 'name' cannot be blank", 400);
        }

        $location->setName($request->request->get('name'));
        $entityManager->flush();

        $data = [
            'id' => $id,
            'name' => $location->getName(),
        ];

        return $this->json($data, 200);
    }


    /**
     * @Route("/locations/{id}", name="location_delete", methods={"DELETE"})
     */
    public function delete(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $location = $this->getDoctrine()->getRepository(Location::class)->find($id);

        if(!$location)
        {
            return $this->json("Location was not found with id " . $id, 404);
        }

        $machine = $this->getDoctrine()->getRepository(Machine::class)->findBy(array('location' => $id));

        if($machine)
        {
            return $this->json("Cannot delete location, because it has dependency with machine", 400);
        }

        $entityManager->remove($location);
        $entityManager->flush();

        return $this->json('Location was removed successfully with id ' . $id, 204);
    }
}
