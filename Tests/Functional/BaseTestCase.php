<?php

namespace JMS\JobQueueBundle\Tests\Functional;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\KernelInterface;

class BaseTestCase extends WebTestCase
{
    protected static function createKernel(array $options = []): KernelInterface
    {
        $config = isset($options['config']) ? $options['config'] : 'default.yml';

        return new AppKernel($config);
    }

    final protected function importDatabaseSchema(): void
    {
        foreach (self::$kernel->getContainer()->get('doctrine')->getManagers() as $em) {
            $this->importSchemaForEm($em);
        }
    }

    private function importSchemaForEm(EntityManager $em): void
    {
        $metadata = $em->getMetadataFactory()->getAllMetadata();
        if (!empty($metadata)) {
            $schemaTool = new SchemaTool($em);
            $schemaTool->createSchema($metadata);
        }
    }
}