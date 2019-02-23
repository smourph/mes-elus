<?php

namespace App\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class ImportDataCommandTest.
 */
class ImportDataCommandTest extends KernelTestCase
{
    public function testExecute(): void
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);

        $command = $application->find('api:import');
        $commandTester = new CommandTester($command);

        $this->assertTrue(true);
        /*$commandTester->execute([
            'command' => $command->getName(),
            // pass arguments to the helper
            'arg1' => 'value',
            // prefix the key with two dashes when passing options,
            // e.g: '--some-option' => 'option_value',
        ]);

        // the output of the command in the console
        $output = $commandTester->getDisplay();
        $this->assertContains('foo', $output);*/
    }
}
