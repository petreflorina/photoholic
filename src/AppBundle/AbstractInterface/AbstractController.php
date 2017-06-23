<?php

namespace AppBundle\AbstractInterface;

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

use AppBundle\EntityResource\PictureResource;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AbstractController extends Controller
{

    /**
     * @param $options
     * @return array|null|object
     */
    public function generateDoctrineResponse($options)
    {
        $entity = null;

        if ($options['function'] === 'findAll') {
            $entity = $this->getDoctrine()->getManager()
                ->getRepository($options['repository'])
                ->findAll();
        } elseif ($options['criteria']) {
            $entity = $this->getDoctrine()->getManager()
                ->getRepository($options['repository'])
                ->findOneBy([$options['criteria'] => $options['parameter']]);
        }

        return $entity;
    }

    /**
     * @param $options
     * @return array|object|\Symfony\Component\Serializer\Normalizer\scalar
     */
    public function _normalize($options)
    {
        $encoders = array(new JsonEncoder());

        // recognizes the groups from annotations
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));

        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer], $encoders);


        return $serializer->normalize($options['data'], null, ['groups' => $options['group']]);

    }

    /**
     * @param options = [
     *      'data' array|object
     *      'group' array
     *      'repository' string
     *      'parameter' integer|string
     *      'criteria' string
     *      'function' string
     *]
     * @return JsonResponse
     */
    public function getSerializedResponse($options, $returnOnlyData = false)
    {
        $resolver = New OptionsResolver();
        $resolver->setDefined([
            'data',
            'group',
            'repository',
            'parameter',
            'criteria',
            'function'
        ])
            ->setAllowedTypes('data', ['string', 'object', 'array', 'null'])
            ->setAllowedTypes('group', ['array', 'null'])
            ->setAllowedTypes('repository', ['string', 'null'])
            ->setAllowedTypes('parameter', ['string', 'numeric', 'null'])
            ->setAllowedTypes('criteria', ['string', 'null'])
            ->setAllowedTypes('function', ['string', 'null'])
            ->setDefaults([
                'data' => null,
                'group' => [],
                'repository' => null,
                'parameter' => null,
                'criteria' => null,
                'function' => null
            ]);
        $options = $resolver->resolve($options);

        $entity = $this->generateDoctrineResponse($options);

        if (!$options['data']) {
            $options['data'] = $entity;
        }

        $data = $this->_normalize($options);

        return new JsonResponse(['data' => $data]);
    }

    /**
     * @param $entity
     * @param $message
     * @param $method
     * @param bool $returnEntity
     * @return string|JsonResponse
     */
    protected function _handleDatabaseMethod($entity, $message, $method, $returnEntity = false)
    {
        $em = $this->getDoctrine()->getManager();

        try {
            if ($method == 'create') {
                $em->persist($entity);
            } elseif ($method == 'delete') {
                $em->remove($entity);
            }
            $em->flush();
        } catch (\Exception $e) {
            return $message = $e->getMessage() . '/ database error';
        }

        if (is_string($returnEntity)) {
            return $this->_normalize([
                'data' => $entity,
                'group' => [$returnEntity]
            ]);
        }

        return $message;
    }

    /**
     * @param $object object
     * @param string $method
     * @param string $message
     * @param null $id
     * @param bool $returnEntity
     * @return string
     */
    protected function _handleResource($object, $method, $message, $id = null, $returnEntity = false)
    {
        /**
         * calls the 'method' from the 'resource object' passing 'arguments []'
         */
        $entity = call_user_func_array([$object, $method], [$id]);

        if ($this->handleErrors($entity)) {
            return $this->handleErrors($entity);
        }

        return new JsonResponse(['data' => $this->_handleDatabaseMethod($entity, $message, $method, $returnEntity)]);
    }

    /**
     * @return JsonResponse
     */
    public function uploadPicture()
    {
        $request = Request::createFromGlobals();

        $message = "No file selected";

        foreach ($request->files as $uploadedFile) {

            $picture = call_user_func_array(
                [new PictureResource($this->container), 'create'],
                [$uploadedFile, $this->getParameter('pictures_directory')]
            );

            if ($this->handleErrors($picture)) {
                return $this->handleErrors($picture);
            }

            $message = $this->_handleDatabaseMethod($picture, 'The picture was successfully added!', 'create');
        }

        return new JsonResponse(['data' => $message]);
    }

    /**
     * @param $entity
     * @return JsonResponse
     */
    public function handleErrors($entity)
    {
        $validator = $this->get('validator');
        $errors = $validator->validate($entity);

        if (count($errors) > 0) {
            /*
             * Uses a __toString method on the $errors variable which is a
             * ConstraintViolationList object. This gives us a nice string
             * for debugging.
             */
            $errorsString = (string)$errors;

            return new JsonResponse(['data' => $errorsString]);
        }
    }
}