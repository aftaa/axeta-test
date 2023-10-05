<?php

namespace App\DataFixtures;

use App\Entity\Candidate;
use App\Entity\Portfolio;
use App\Entity\Skill;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class JohnSmithFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $candidate = new Candidate();
        $candidate
            ->setName('John Smith')
            ->setPlace('Portland, Oregon, USA')
            ->setPhoto('/userpics/1.png')
            ->setCode('')
            ->setAvailability('Full-time')
            ->setEnvironment('GitHub, Mac OSX')
            ->setAmaizing('The only true wisdom is in knowing you know nothing...')
            ->setExpectation('There is only one good, knowledge, and one evil, ignorance.')
            ->setLang('English');

        $skills = [
            'PHP' => 6,
            'Ruby' => 2,
            'Java Script' => 4.5,
        ];

        foreach ($skills as $name => $experience) {
            $skill = new Skill();
            $skill->setName($name)->setExperience($experience);
            $candidate->addSkill($skill);
        }

        $portfolios = [
            'Bootstrap 4 Material Design (Sample Link)',
            'Modern JavaScript stack',
            'Datepicker for twitter bootstrap',
            'Fast and reliable Bootstrap widgets in Angular',
        ];

        foreach ($portfolios as $name) {
            $portfolio = new Portfolio();
            $portfolio->setName($name)->setHref('#');
            $candidate->addPortfolio($portfolio);
        }

        $manager->persist($candidate);
        $manager->flush();
    }
}
