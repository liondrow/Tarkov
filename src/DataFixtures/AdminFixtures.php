<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminFixtures extends BaseFixtures
{

    public function __construct(private readonly UserPasswordHasherInterface $hasher) {}

    const COUNT = 1;

    protected function loadData(ObjectManager $em): void
    {
        $this->createMany(Admin::class, self::COUNT, function(Admin $admin) {
			$admin->setEmail("admin@test.com");
			$admin->setPassword($this->hasher->hashPassword($admin, "admin"));
			$admin->setRoles(["ROLE_ADMIN"]);
        });
        $em->flush();
    }
}
