<?php

namespace Domain;

use Infra\Uuid;

class Client
{
    protected string $id;

    public function __construct(
        protected string $nom,
        protected string $email,
        ?string $id = null
    )
    {
        $this->id = $id ?? Uuid::uuid4()->toString();

        // Valider l'adresse email
        if(!$this->checkEmail())
        {
            throw new \Exception("Email is not valid");
        }
    }

    /**
     * Retourne un nouvel objet modifier
     * @param string $nom
     * @param string $email
     * @return $this
     * @throws \Exception
     */
    public function clone(string $nom, string $email): self
    {
        $customer = new static(
            nom: $this->nom,
            email: $this->email,
            id: $this->id,
        );

        return $customer;
    }

    /**
     * Valider l'adresse email de l'utilisateur
     * @return bool
     */
    private function checkEmail(): bool
    {
        return filter_var($this->email, FILTER_VALIDATE_EMAIL);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }

    /**
     * Offusquer les données du client conformément au RGPD
     * @return void
     */
    public function offusquer()
    {
        $this->nom = "****";
        $this->email = "****@****.**";
    }
}