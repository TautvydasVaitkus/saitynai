<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\Location;
use App\Entity\Machine;
use App\Form\Type\CustomerType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/api/v1", name="_api")
 */

class CustomerController extends AbstractApiController
{

    /**
     * @Route("/customers", name="customers_list", methods={"GET"})
     */
    public function indexAction(Request $request): Response
    {
        $customers = $this->getDoctrine()->getRepository(Customer::class)->findAll();

        return $this->json($customers);
    }

    /**
     * @Route("/locations/{locationId}/machines/{machineId}/customers", name="machine_customer_show", methods={"GET"})
     */
    public function machineCustomer(int $locationId, int $machineId)
    {
        $location = $this->getDoctrine()->getRepository(Location::class)->find($locationId);

        if(!$location)
        {
            return $this->json("Location was not found with id " . $locationId, 404);
        }

        $machine = $this->getDoctrine()->getRepository(Machine::class)->find($machineId);

        if(!$machine)
        {
            return $this->json("Machine was not found with id " . $machineId, 404);
        }

        if($locationId != $machine->getLocation()->getId())
        {
            return $this->json("This location doesn't have a machine with id " . $machineId, 404);
        }

        $customer = $this->getDoctrine()->getRepository(Customer::class)->findBy(array('machine' => $machineId));

        return $this->json($customer);
    }

    /**
     * @Route("/locations/{locationId}/machines/{machineId}/customers/{id}", name="customer_show", methods={"GET"})
     */
    public function show(int $locationId, int $machineId, int $id): Response
    {
        $location = $this->getDoctrine()->getRepository(Location::class)->find($locationId);

        if(!$location)
        {
            return $this->json("Location was not found with id " . $locationId, 404);
        }

        $machine = $this->getDoctrine()->getRepository(Machine::class)->find($machineId);

        if(!$machine)
        {
            return $this->json("Machine was not found with id " . $machineId, 404);
        }

        if($locationId != $machine->getLocation()->getId())
        {
            return $this->json("This location doesn't have a machine with id " . $machineId, 404);
        }

        $customer = $this->getDoctrine()->getRepository(Customer::class)->find($id);

        if(!$customer)
        {
            return $this->json("Customer was not found with id " . $id, 404);
        }

        $data = [
            'firstName' => $customer->getFirstName(),
            'lastName' => $customer->getLastName(),
            'email' => $customer->getEmail(),
        ];

        return $this->json($data, 200);
    }

    /**
     * @Route("/locations/{locationId}/machines/{machineId}/customers", name="customer_create", methods={"POST"})
     */
    public function createAction(Request $request, int $locationId, int $machineId): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $location = $this->getDoctrine()->getRepository(Location::class)->find($locationId);

        if(!$location)
        {
            return $this->json("Location was not found with id " . $locationId, 404);
        }

        $machine = $this->getDoctrine()->getRepository(Machine::class)->find($machineId);

        $firstName = $request->request->get('firstName');
        $lastName = $request->request->get('lastName');
        $email = $request->request->get('email');

        if($firstName == "")
        {
            return $this->json("Field 'firstName' cannot be blank", 400);
        }

        if($lastName == "")
        {
            return $this->json("Field 'lastName' cannot be blank", 400);
        }

        if($email == "")
        {
            return $this->json("Field 'email' cannot be blank", 400);
        }

        $customer = new Customer();
        $customer->setFirstName($request->request->get('firstName'));
        $customer->setLastName($request->request->get('lastName'));
        $customer->setEmail($request->request->get('email'));

        $customer->setMachine($machine);

       $this->getDoctrine()->getManager()->persist($customer);
       $this->getDoctrine()->getManager()->flush();

       return $this->json($customer, 201);
    }

    /**
     * @Route("/locations/{locationId}/machines/{machineId}/customers/{id}", name="customer_edit", methods={"PUT"})
     */
    public function edit(int $id, int $locationId, int $machineId, Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $location = $this->getDoctrine()->getRepository(Location::class)->find($locationId);

        if(!$location)
        {
            return $this->json("Location was not found with id " . $locationId, 404);
        }

        $machine = $this->getDoctrine()->getRepository(Machine::class)->find($machineId);


        $this->getDoctrine()->getManager()->persist($machine);
        $this->getDoctrine()->getManager()->flush();

        $customer = $this->getDoctrine()->getRepository(Customer::class)->find($id);

        if(!$customer)
        {
            return $this->json("Customer does not exist", 404);
        }

        $firstName = $request->request->get('firstName');
        $lastName = $request->request->get('lastName');
        $email = $request->request->get('email');

        if($firstName == "")
        {
            return $this->json("Field 'firstName' cannot be blank", 400);
        }

        if($lastName == "")
        {
            return $this->json("Field 'lastName' cannot be blank", 400);
        }

        if($email == "")
        {
            return $this->json("Field 'email' cannot be blank", 400);
        }

        $customer->setFirstName($request->request->get('firstName'));
        $customer->setLastName($request->request->get('lastName'));
        $customer->setEmail($request->request->get('email'));
        $entityManager->flush();

        $data = [
            'id' => $customer->getId(),
            'firstName' => $customer->getFirstName(),
            'lastName' => $customer->getLastName(),
            'email' => $customer->getEmail(),
        ];

        return $this->json($data, 200);
    }

    /**
     * @Route("/locations/{locationId}/machines/{machineId}/customers/{id}", name="customer_delete", methods={"DELETE"})
     */
    public function delete(int $locationId, int $machineId, int $id, Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $location = $this->getDoctrine()->getRepository(Location::class)->find($locationId);

        if(!$location)
        {
            return $this->json("Location was not found with id " . $locationId, 404);
        }

        $machine = $this->getDoctrine()->getRepository(Machine::class)->find($machineId);


        $this->getDoctrine()->getManager()->persist($machine);
        $this->getDoctrine()->getManager()->flush();

        $customer = $this->getDoctrine()->getRepository(Customer::class)->find($id);

        if(!$customer)
        {
            return $this->json("Customer does not exist", 404);
        }

        $entityManager->remove($customer);
        $entityManager->flush();

        return $this->json("Customer was removed successfully with id " . $id, 204);
    }
}
