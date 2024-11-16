<?php

namespace Domain;

use Infra\Uuid;

class Customer
{
    protected string $id;

    public function __construct(
        protected string $name,
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

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'email' => $this->getEmail(),
            'name' => $this->getName()
        ];
    }
}