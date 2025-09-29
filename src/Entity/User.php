<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use App\Components\Encryption;

#[ORM\Table(name: 'user')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    protected ?int $id;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string')]
    private ?string $login;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string')]
    private ?string $password;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getLogin(): ?string
    {
        return Encryption::decrypt($this->login);
    }

    /**
     * @param string $login
     * 
     * @return self
     */
    public function setLogin(string $login): self
    {
        $this->login = Encryption::encrypt($login);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return Encryption::decrypt($this->password);
    }

    /**
     * @param string $password
     * 
     * @return self
     */
    public function setPassword(string $password): self
    {
        $this->password = Encryption::encrypt($password);

        return $this;
    }
}
