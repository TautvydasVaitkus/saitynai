<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MachineRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MachineRepository::class)
 * @ORM\Table(name="machine")
 * @ApiResource()
 */
class Machine
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     */
    private $cpu;

    /**
     * @ORM\Column(type="string")
     */
    private $storage;

    /**
     * @ORM\Column(type="string")
     */
    private $ram;

    /**
     * @ORM\Column (type="integer")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Location", inversedBy="machines")
     */
    private $location;

    /**
     * @Orm\OneToOne(targetEntity="App\Entity\Customer", inversedBy="machine")
     */
    private $customer;

    /**
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getCpu()
    {
        return $this->cpu;
    }

    /**
     * @param string|null $cpu
     */
    public function setCpu($cpu): void
    {
        $this->cpu = $cpu;
    }

    /**
     * @return string|null
     */
    public function getStorage()
    {
        return $this->storage;
    }

    /**
     * @param string|null $storage
     */
    public function setStorage($storage): void
    {
        $this->storage = $storage;
    }

    /**
     * @return string|null
     */
    public function getRam()
    {
        return $this->ram;
    }

    /**
     * @param string|null $ram
     */
    public function setRam($ram): void
    {
        $this->ram = $ram;
    }

    /**
     * @return string|null
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param string|null $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return Customer
     */
    public function getCustomer(): Customer
    {
        return $this->customer;
    }


}
