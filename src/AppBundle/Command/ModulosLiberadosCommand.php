<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ModulosLiberadosCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:modulos:liberados')
            ->setDescription('Envía por correo electrónico comentarios sin publicar')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $released = $this->getContainer()->get('app.modulos_liberados')->send();
    }
}


?>
