<?php

namespace App\Controller;

use App\Entity\Customer;
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
     * @Route("/locations/{id}/machines", name="machines_create", methods={"POST"})
     */
    public function createAction(Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $location = $this->getDoctrine()->getRepository(Location::class)->find($id);

        if(!$location)
        {
            return $this->json("Location was not found with id " . $id, 404);
        }

        $name = $request->request->get('name');
        $cpu = $request->request->get('cpu');
        $storage = $request->request->get('storage');
        $ram = $request->request->get('ram');
        $price = $request->request->get('price');

        if($name == "") {
            return $this->json("Field 'name' cannot be blank", 400);
        }

        if($cpu == "") {
            return $this->json("Field 'cpu' cannot be blank", 400);
        }

        if($storage == "") {
            return $this->json("Field 'storage' cannot be blank", 400);
        }

        if($ram == "") {
            return $this->json("Field 'ram' cannot be blank", 400);
        }

        if($price == "") {
            return $this->json("Field 'price' cannot be blank", 400);
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

        return $this->json($machine, 201);
    }

    /**
     * @Route("/locations/{locationId}/machines/{id}", name="machine_show", methods={"GET"})
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

        return $this->json($data, 200);
    }

    /**
     * @Route("/locations/{locationId}/machines/{id}", name="machine_edit", methods={"PUT"})
     */
    public function edit(int $id, int $locationId, Request $request): Response
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

        $name = $request->request->get('name');
        $cpu = $request->request->get('cpu');
        $storage = $request->request->get('storage');
        $ram = $request->request->get('ram');
        $price = $request->request->get('price');

        if($name == "") {
            return $this->json("Field 'name' cannot be blank", 400);
        }

        if($cpu == "") {
            return $this->json("Field 'cpu' cannot be blank", 400);
        }

        if($storage == "") {
            return $this->json("Field 'storage' cannot be blank", 400);
        }

        if($ram == "") {
            return $this->json("Field 'ram' cannot be blank", 400);
        }

        if($price == "") {
            return $this->json("Field 'price' cannot be blank", 400);
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

        return $this->json($data, 200);
    }

    /**
     * @Route("/locations/{locationId}/machines/{id}", name="machine_delete", methods={"DELETE"})
     */
    public function delete(int $id, Request $request, $locationId): Response
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

        $customer = $this->getDoctrine()->getRepository(Customer::class)->findBy(array('machine' => $id));

        if($customer) {
            return $this->json("Cannot delete machine, because it has dependency with customer", 400);
        }

        $entityManager->remove($machine);
        $entityManager->flush();

        return $this->json("Machine was removed successfully with id " . $id, 204);
    }
}
