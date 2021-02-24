<?php

namespace App\DataFixtures;

use App\Entity\Project;
use App\Entity\SchoolYear;
use App\Entity\User;
use DateTime ;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    private $manager;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $this->loadUser(60, "ROLE_STUDENT");
        $this->loadUser(5, "ROLE_TEACHER");
        $this->loadUser(15, "ROLE_CLIENT");

        $this->loadProject(20);

        $this->loadSchoolYear(3);

        $this->loadUserSchoolYearRelation(3);
    }

    public function loadUser(int $count, string $role) : void
    {


        // @todo créer un faux utilisateur sans aucun privilège mais avec l'id 1

        // créer un user ROLE_ADMIN
        $user = new User();
        $firstname = 'foo';
        $lastname = 'bar';
        $email = 'foobar@example.com';
        $roles = ["ROLE_ADMIN"];
        $password = $this->encoder->encodePassword($user, '123');
        $phone = null;
        $user->setFirstname($firstname)
        ->setLastname($lastname)
        ->setEmail($email)
        ->setPhone($phone)
        ->setRoles($roles)
        ->setPassword($password);
        $this->manager->persist($user);
        $this->manager->flush();

        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 0; $i < $count; $i++) {
            $user = new User();
            $firstname = $faker->firstname();
            $lastname = $faker->lastname();
            $email = strtolower($firstname).'.'.strtolower($lastname).'-'.$i.'@exemple.com';
            $role = [$role];
            $password = $password = $this->encoder->encodePassword($user, '123');
            $phone = str_replace(' ', '', $faker->phoneNumber());
            
            $user->setFirstname($firstname)
                ->setLastname($lastname)
                ->setEmail($email)
                ->setPhone($phone)
                ->setPassword($password);

            $this->manager->persist($user);
        }
        $this->manager->flush();
    }

    public function loadProject(int $count): void
    {

        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 0; $i < $count; $i++) {
            $name = $faker->sentence(4);
            if (random_int(1, 100) <= 25) {
                $description = $faker->realText(200);
            } else {
                $description = null;
            }
            
            $project = new Project();
            $project->setName($name)
                    ->setDescription($description);
            
            $this->manager->persist($project);
        }
        $this->manager->flush();
    }

    public function loadSchoolYear(int $count) : void
    {
        
        // il y a 2 school year par an
        // la première le 01/01
        // la deuxième le 01/07
        $year = 2020;
        
        $faker = \Faker\Factory::create('fr_FR');


        for ($i=0; $i < $count; $i++) {
            $name = $faker->realText(100);
            $dateStart = new DateTime();
            $dateEnd = new DateTime();

            if ($i % 2 == 0) {
                // Nb pair
                $dateStart->setDate($year, 1, 1);
                $dateEnd->setDate($year, 6, 30);
            } else {
                $dateStart->setDate($year, 7, 1);
                $dateEnd->setDate($year, 12, 31);
            }

            if ($i % 2 != 0) {
                $year++;
            }

            $schoolYear = new SchoolYear();
            $schoolYear->setName($name)
                    ->setDateStart($dateStart)
                    ->setDateEnd($dateEnd);

            $this->manager->persist($schoolYear);
        }
        $this->manager->flush();
    }

    public function loadUserSchoolYearRelation(int $countSchoolYear) : void
    {
        $schoolYearRepository = $this->manager->getRepository(SchoolYear::class);
        $schoolYears = $schoolYearRepository->findAll();

        $userRepository = $this->manager->getRepository(User::class);
        $users = $userRepository->findBy([
            'roles' => ["ROLE_STUDENT"]
        ]);

        foreach ($users as $i => $user) {
            $remainder = $i % $countSchoolYear;
            $user->setSchoolYear($schoolYear->get($remainder));

            $this->manager->persist($user);
        }
        $this->manager->flush();
    }
}
