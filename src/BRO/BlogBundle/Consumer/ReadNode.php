<?php

// src/Acme/DemoBundle/Consumer/ReadNode.php

namespace BRO\BlogBundle\Consumer;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\HttpKernel\Log\LoggerInterface;

class ReadNode implements ConsumerInterface
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function execute(AMQPMessage $msg)
    {
        // $msg->body is a data sent by RabbitMQ, in our example it contains XML
        $sxe = new \SimpleXMLElement($msg->body);

        // Now it's completely up to what you will do with this XML
        // You can do anything! But we will just log that we processed XML node

        $this->logger->info(sprintf('Node processed: "%s"', $sxe->title));
    }
}