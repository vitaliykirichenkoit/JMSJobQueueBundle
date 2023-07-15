<?php declare(strict_types=1);

namespace JMS\JobQueueBundle\Tests\Functional;

use Symfony\Component\Console\Output\Output;

class MemoryOutput extends Output
{
    protected string $output = '';

    protected function doWrite(string $message, bool $newline): void
    {
        $this->output .= $message;

        if ($newline) {
            $this->output .= "\n";
        }
    }

    public function getOutput(): string
    {
        return $this->output;
    }
}
