<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\SessionRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
class Session
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column(length: 255)]
	private ?string $intitule = null;

	#[ORM\Column]
	private ?int $place = null;

	#[ORM\Column(type: Types::DATETIME_MUTABLE)]
	private ?\DateTimeInterface $dateDebut = null;

	#[ORM\Column(type: Types::DATETIME_MUTABLE)]
	private ?\DateTimeInterface $dateFin = null;

	#[ORM\ManyToMany(targetEntity: Stagiaire::class)]
	private Collection $participer;

	#[ORM\ManyToOne]
	private ?Formateur $formateur = null;

	#[ORM\ManyToOne]
	private ?Formation $formation = null;

	public function __construct()
	{
		$this->participer = new ArrayCollection();
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getIntitule(): ?string
	{
		return $this->intitule;
	}

	public function setIntitule(string $intitule): self
	{
		$this->intitule = $intitule;

		return $this;
	}

	public function getPlace(): ?int
	{
		return $this->place;
	}

	public function setPlace(int $place): self
	{
		$this->place = $place;

		return $this;
	}

	public function getDateDebut(): ?\DateTimeInterface
	{
		return $this->dateDebut;
	}

	public function setDateDebut(\DateTimeInterface $dateDebut): self
	{
		$this->dateDebut = $dateDebut;

		return $this;
	}

	public function getDateFin(): ?\DateTimeInterface
	{
		return $this->dateFin;
	}

	public function setDateFin(\DateTimeInterface $dateFin): self
	{
		$this->dateFin = $dateFin;

		return $this;
	}

	public function getDuree(): ?string
	{
		$duree = date_diff($this->getDateFin(), $this->getDateDebut());
		return $duree->days;
	}

	public function addSession(ManagerRegistry $doctrine, Session $session): self
	{
		$em = $doctrine->getManager();
		$$session = new Session($session);
		$em->persist($session);
		$em->flush();


		return $this;
	}

	/**
	 * @return Collection<int, Stagiaire>
	 */

	public function getParticiper(): Collection
	{
		return $this->participer;
	}

	public function addParticiper(Stagiaire $participer): self
	{
		if (!$this->participer->contains($participer)) {
			$this->participer->add($participer);
		}

		return $this;
	}

	public function removeParticiper(Stagiaire $participer): self
	{
		$this->participer->removeElement($participer);

		return $this;
	}

	public function getFormateur(): ?Formateur
	{
		return $this->formateur;
	}

	public function setFormateur(?Formateur $formateur): self
	{
		$this->formateur = $formateur;

		return $this;
	}

	public function getFormation(): ?Formation
	{
		return $this->formation;
	}

	public function setFormation(?Formation $formation): self
	{
		$this->formation = $formation;

		return $this;
	}

	public function __toString()
	{
		return $this->intitule;
	}
}
