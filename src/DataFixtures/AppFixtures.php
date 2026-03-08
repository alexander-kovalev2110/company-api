<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\Employee;
use App\Entity\Project;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Companies
        for ($i = 1; $i <= 5; $i++) {

            $company = new Company();
            $company->setName("Company $i");
            $company->setEmail("company$i@example.com");

            $manager->persist($company);

            // Employees
            for ($j = 1; $j <= 3; $j++) {

                $employee = new Employee();
                $employee->setName("Employee {$i}_{$j}");
                $employee->setEmail("employee{$i}{$j}@example.com");
                $employee->setCompany($company);

                $manager->persist($employee);
            }

            // Projects
            for ($k = 1; $k <= 2; $k++) {

                $project = new Project();
                $project->setName("Project {$i}_{$k}");
                $project->setDescription("Description for project {$i}_{$k}");
                $project->setCompany($company);

                $manager->persist($project);
            }
        }

        $manager->flush();
    }
}