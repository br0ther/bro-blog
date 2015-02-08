<?php
namespace BRO\BlogBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ReadFileCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('reader:read-file');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getContainer()->get('split_file')->process();
    }
}