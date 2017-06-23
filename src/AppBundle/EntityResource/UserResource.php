<?php

namespace AppBundle\EntityResource;

use AppBundle\AbstractInterface\AbstractResource;
use AppBundle\Entity\User;

class UserResource extends AbstractResource
{
    /**
     * @return User
     */
    public function create()
    {

        $user = new User();

        $user = $this->_self($user);

        return $user;
    }

    /**
     * @param $id
     * @return User
     */
    public function change($id)
    {
        $user = $this->findById('AppBundle:User', $id);

        $this->_self($user);

        return $user;
    }

    public function delete($id)
    {
        $user = $this->findById('AppBundle:User', $id);
        //delete the relations

        return $user;
    }

    /**
     * @param $entity
     * @return mixed
     */
    private function _self(User $entity)
    {
        $requestContent = $this->decoder();

        $encoder = $this->container->get('security.password_encoder');
        $encodedPassword = $encoder->encodePassword($entity, $requestContent['password']);

        $entity->setUsername($requestContent['username']);
        $entity->setPassword($encodedPassword);
        $entity->setEmail($requestContent['email']);
        $entity->setFirstName($requestContent['firstName']);
        $entity->setLastName($requestContent['lastName']);
        $entity->setCameraModel($requestContent['cameraModel']);
        $entity->setPhotographerSince(new \DateTime($requestContent['photographerSince']));

        return $entity;

    }
}