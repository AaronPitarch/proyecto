<?php

namespace App\Entity;

use App\Repository\PlatoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlatoRepository::class)
 */
class Plato
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descripcion;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imagen_url;

    /**
     * @ORM\Column(type="float")
     */
    private $precio;

    /**
     * @ORM\ManyToOne(targetEntity=Restaurante::class, inversedBy="platos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $restaurante;

    /**
     * @ORM\ManyToMany(targetEntity=Alergenos::class)
     */
    private $alergenos;

    public function __construct()
    {
        $this->alergenos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getImagenUrl(): ?string
    {
        return $this->imagen_url;
    }

    public function setImagenUrl(string $imagen_url): self
    {
        $this->imagen_url = $imagen_url;

        return $this;
    }

    public function getPrecio(): ?float
    {
        return $this->precio;
    }

    public function setPrecio(float $precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    public function getRestaurante(): ?Restaurante
    {
        return $this->restaurante;
    }

    public function setRestaurante(?Restaurante $restaurante): self
    {
        $this->restaurante = $restaurante;

        return $this;
    }

    /**
     * @return Collection<int, Alergenos>
     */
    public function getAlergenos(): Collection
    {
        return $this->alergenos;
    }

    public function addAlergeno(Alergenos $alergeno): self
    {
        if (!$this->alergenos->contains($alergeno)) {
            $this->alergenos[] = $alergeno;
        }

        return $this;
    }

    public function removeAlergeno(Alergenos $alergeno): self
    {
        $this->alergenos->removeElement($alergeno);

        return $this;
    }
}
