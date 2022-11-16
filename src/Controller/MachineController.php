<?php

namespace App\Controller;

use App\Entity\Machine;
use App\Entity\Location;
use App\Form\Type\MachineType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/api/v1", name="_api")
 */
class MachineController extends AbstractApiController
{
    /**
     * @Route("/machines", name="machines_list", methods={"GET"})
     */
    public function indexAction(Request $request): Response
    {
        $machines = $this->getDoctrine()->getRepository(Machine::class)->findAll();

        return $this->json($machines);
    }

    /**
     * @Route("/locations/{locationId}/machines", name="location_machines_list", methods={"GET"})
     */
    public function locationMachines(int $locationId): Response
    {
        $machines = $this->getDoctrine()->getRepository(Machine::class)->findBy(array('location' => $locationId));

        return $this->json($machines);
    }

    /**
     * @Route("/locations/{id}/machines/create", name="machines_create", methods={"POST"})
     */
    public function createAction(Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $location = $this->getDoctrine()->getRepository(Location::class)->find($id);

        if(!$location)
        {
            return $this->json("Location was not found with id " . $id, 404);
        }

        $machine = new Machine();
        $machine->setName($request->request->get('name'));
        $machine->setCpu($request->request->get('cpu'));
        $machine->setStorage($request->request->get('storage'));
        $machine->setRam($request->request->get('ram'));
        $machine->setPrice($request->request->get('price'));

        $machine->setLocation($location);


        $this->getDoctrine()->getManager()->persist($machine);
        $this->getDoctrine()->getManager()->flush();

        return $this->json($machine);
    }

    /**
     * @Route("/locations/{locationId}/machines/{id}")
     */
    public function show(int $id, int $locationId): Response
    {
        $location = $this->getDoctrine()->getRepository(Location::class)->find($locationId);

        if(!$location)
        {
            return $this->json("Location was not found with id " . $locationId, 404);
        }

        $machine = $this->getDoctrine()->getRepository(Machine::class)->find($id);

        if(!$machine)
        {
            return $this->json("Machine was not found with id " . $id, 404);
        }

        if($locationId != $machine->getLocation()->getId())
        {
            return $this->json("This location doesn't have a machine with id " . $id, 404);
        }

        $data = [
            'name' => $machine->getName(),
            'cpu' => $machine->getCpu(),
            'storage' => $machine->getStorage(),
            'ram' => $machine->getRam(),
            'price' => $machine->getPrice(),
        ];

        return $this->json($data);
    }

    /**
     * @Route("/locations/{locationId}/machines/edit/{id}", name="machine_edit", methods={"PUT"})
     */
    public function edit(int $locationId, int $id, Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $location = $this->getDoctrine()->getRepository(Location::class)->find($locationId);

        if(!$location)
        {
            return $this->json("Location was not found with id " . $locationId, 404);
        }

        $machine = $this->getDoctrine()->getRepository(Machine::class)->find($id);

        if(!$machine)
        {
            return $this->json("Machine was not found with id " . $id, 404);
        }

        if($locationId != $machine->getLocation()->getId())
        {
            return $this->json("This location doesn't have a machine with id " . $id, 404);
        }

        $machine->setName($request->request->get('name'));
        $machine->setCpu($request->request->get('cpu'));
        $machine->setStorage($request->request->get('storage'));
        $machine->setRam($request->request->get('ram'));
        $machine->setPrice($request->request->get('price'));
        $machine->setLocation($location);
        $entityManager->flush();

        $data = [
            'name' => $machine->getName(),
            'cpu' => $machine->getCpu(),
            'storage' => $machine->getStorage(),
            'ram' => $machine->getRam(),
            'price' => $machine->getPrice(),
        ];

        return $this->json($data);
    }

    /**
     * @Route("/locations/{locationId}/machines/delete/{id}", name="machine_delete", methods={"DELETE"})
     */
    public function delete(int $locationId, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $location = $this->getDoctrine()->getRepository(Location::class)->find($locationId);

        if(!$location)
        {
            return $this->json("Location was not found with id " . $locationId, 404);
        }

        $machine = $this->getDoctrine()->getRepository(Machine::class)->find($id);

        if(!$machine)
        {
            return $this->json("Machine was not found with id " . $id, 404);
        }

        if($locationId != $machine->getLocation()->getId())
        {
            return $this->json("This location doesn't have a machine with id " . $id, 404);
        }

        $entityManager->remove($machine);
        $entityManager->flush();

        return $this->json("Machine was removed successfully with id " . $id);
    }
}