<?php

namespace AppBundle\Model\Admin;

use Doctrine\ORM\EntityManager;

class RolesManager
{
    protected $em;
    protected $class;
    protected $repository;

    /**
     * Constructor
     * @param EntityManager em
     * @param string        $class
     */

    function __construct(EntityManager $em, $class)
    {
        $this->em         = $em;
        $this->repository = $this->em->getRepository($class);
        $metadata         = $this->em->getClassMetadata($class);
        $this->class      = $metadata->name;
    }

    public function create()
    {
        $class = $this->getClass();

        return new $class;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function findAll()
    {
        return $this->repository->findAll();
    }

    public function save($model)
    {

        $this->_save($model);
    }

    protected function _save($model)
    {
        $this->em->persist($model);
        $this->em->flush();
    }

    public function delete($model)
    {
        $this->_delete($model);
    }

    protected function _delete($model)
    {
        $this->remove($model);
        $this->em->flush();
    }

    public function update() {
        $this->em->flush();
    }


}



?>
