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
     * @Route("/locations/{locationId}/machines/{machineId}/customer", name="machine_customer_show", methods={"GET"})
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
     * @Route("/customer/create", name="customer_create", methods={"POST"})
     */
    public function createAction(Request $request, int $locationId, int $machineId): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $customer = new Customer();
        $customer->setFirstName($request->request->get('firstName'));
        $customer->setLastName($request->request->get('lastName'));
        $customer->setEmail($request->request->get('email'));


       $this->getDoctrine()->getManager()->persist($customer);
       $this->getDoctrine()->getManager()->flush();

       return $this->json($customer);
    }

    /**
     * @Route("/customers/edit/{id}", name="customer_edit", methods={"PUT"})
     */
    public function edit(Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $customer = $this->getDoctrine()->getRepository(Customer::class)->find($id);

        if(!$customer)
        {
            return $this->json('No customer with this id ' . $id, 404 );
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

        return $this->json($data);
    }

    /**
     * @Route("/customers/delete/{id}", name="customer_delete", methods={"DELETE"})
     */
    public function delete(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $customer = $this->getDoctrine()->getRepository(Customer::class)->find($id);

        if(!$customer)
        {
            return $this->json("Customer was not found with id " . $id, 400);
        }

        $entityManager->remove($customer);
        $entityManager->flush();

        return $this->json("Customer was removed successfully with id " . $id);
    }

    /**
     * @Route("/customers/{id}/machine", name="customer_machine_assign", methods={"PUT"})
     */
    public function customerMachineEdit(int $id, Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $customer = $this->getDoctrine()->getRepository(Customer::class)->find($id);

        if(!$customer)
        {
            return $this->json('No customer with this id ' . $id, 404 );
        }

        $machineId = $request->request->get('machineId');

        if($machineId != null)
        {

            $machine = $this->getDoctrine()->getRepository(Machine::class)->find($machineId);

            if(!$machine)
            {
                return $this->json('No machine with this id ' . $customer->getMachine(), 404 );
            }
        }

        $customer->setFirstName($customer->getFirstName());
        $customer->setLastName($customer->getLastName());
        $customer->setEmail($customer->getEmail());
        if($machineId == null)
        {
            $customer->setMachine(null);
        }
        else {
            $customer->setMachine($machine);
        }

        $entityManager->flush();

        $data = [
            'id' => $customer->getId(),
            'firstName' => $customer->getFirstName(),
            'lastName' => $customer->getLastName(),
            'email' => $customer->getEmail(),
        ];

        return $this->json($data);
    }
}
