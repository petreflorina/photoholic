<?php

namespace AppBundle\AbstractInterface;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * |--------------------------------------------------------------------------
 *
 * @author : Florina Petre, August 2016
 *
 * |--------------------------------------------------------------------------
 *
 *
 *
 *
 *
 */
class AbstractResource
{
    protected $container;
    protected $em;
    protected $request;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->em = $container->get('doctrine')->getManager();
        $this->request = Request::createFromGlobals();
    }

    public function decoder()
    {
        $data = json_decode($this->request->getContent(), true);
        $this->request->request->replace(is_array($data) ? $data : array());

        return $data;
    }

    public function setManyToOne($entityName, $entity, $targetName, $target, $repository)
    {
        if (!empty($target)) {
            $entity->{'set' . ucfirst($targetName)}(
                $this->em->getRepository($repository)
                    ->findOneById($target));
        }

        $target->{'add' . ucfirst($entityName)}($entity);
    }

    public function setManyToMany($entityName, $entity, $targetName, $target, $repository)
    {
        if (!empty($target)) {
            $entity->{'add' . ucfirst($targetName)}(
                $this->em->getRepository($repository)
                    ->findOneById($target));
        }

        $target->{'add' . ucfirst($entityName)}($entity);
    }

    /**
     * @param $repository
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function findById($repository, $id)
    {
        $entity = $this->em->getRepository($repository)
            ->findOneBy([
                'id' => $id
            ]);

        if (!is_object($entity)) {
            throw new \Exception('No valid id!');
        }

        return $entity;
    }

    /**
     * @param $repository
     * @param $username
     * @return mixed
     * @throws \Exception
     * @internal param $id
     */
    public function findByUsername($repository, $username)
    {
        $entity = $this->em->getRepository($repository)
            ->findOneBy([
                'username' => $username
            ]);

        if (!is_object($entity)) {
            throw new \Exception('No valid username!');
        }

        return $entity;
    }

}