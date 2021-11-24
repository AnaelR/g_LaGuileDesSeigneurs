<?php

namespace App\Service;

use DateTime;
use LogicException;
use App\Entity\Character;
use App\Form\CharacterType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CharacterRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use App\Event\CharacterEvent;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CharacterService implements CharacterServiceInterface
{
    private $em;
    private $formFactory;
    private $characterRepository;
    private $validator;
    private $dispatcher;

    public function __construct(CharacterRepository $characterRepository, EntityManagerInterface $em, FormFactoryInterface $formFactory, ValidatorInterface $validator, EventDispatcherInterface $dispatcher)
    {
        $this->characterRepository = $characterRepository;
        $this->em = $em;
        $this->formFactory = $formFactory;
        $this->validator = $validator;
        $this->dispatcher = $dispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function modify(Character $character, string $data)
    {
        $this->submit($character, CharacterType::class, $data);
        
        return $this->modifyFromHtml($character);
    }

    public function modifyFromHtml(Character $character)
    {
        $this->isEntityFilled($character);
        $character
            ->setModification(new \DateTime());


        $this->em->persist($character);
        $this->em->flush();
        return $character;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(Character $character)
    {
        $this->em->remove($character);
        $this->em->flush();

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getAll()
    {
        return $this->characterRepository->findAll();
    }

        /**
     * {@inheritdoc}
     */
    public function getByIntelligence(int $level)
    {
        return $this->characterRepository->findByIntelligence($level);
    }

    /**
     * {@inheritdoc}
     */
    public function getImages(int $number, ?string $kind = null)
    {
        $folder = __DIR__ . '/../../public/images/';

        $finder = new Finder();
        $finder
            ->files()
            ->in($folder)
            ->notPath('/cartes/')
            ->sortByName();

        if (null != $kind) {
            $finder->path('/' . $kind . '/');
        }

        $images = array();
        foreach ($finder as $file) {
            $images[] = '/images/' . $file->getRelativePathname();
        }
        shuffle($images);
        return array_slice($images, 0, $number, true);
    }

    public function create(string $data)
    {
        //Use with {"kind":"Dame","name":"Eldalótë","surname":"Fleur elfique","caste":"Elfe","knowledge":"Arts","intelligence":120,"life":12,"image":"/images/eldalote.jpg"}
        $character = new Character();
        $this->submit($character, CharacterType::class, $data);

        return $this->createFromHtml($character);
    }

    public function createFromHtml(Character $character)
    {
        $character
            ->setIdentifier(hash('sha1', uniqid()))
            ->setCreation(new DateTime())
            ->setModification(new DateTime());
        $this->isEntityFilled($character);

        $this->em->persist($character);
        $this->em->flush();
        //Dispatch event
        $event = new CharacterEvent($character);
        $this->dispatcher->dispatch($event, CharacterEvent::CHARACTER_CREATED);

        return $character;
    }

    /**
     * {@inheritdoc}
     */
    public function isEntityFilled(Character $character)
    {
        // $character->setIdentifier('badidentifier');
        $errors = $this->validator->validate($character);
        if (count($errors) > 0) {
            throw new UnprocessableEntityHttpException((string) $errors . 'Missing data for Entity -> ' .$this->serializeJson($character));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function submit(Character $character, $formName, $data)
    {
        $dataArray = is_array($data) ? $data : json_decode($data, true);

        //Bad array
        if (null !== $data && !is_array($dataArray)) {
            throw new UnprocessableEntityHttpException('Submitted data is not an array -> ' . $data);
        }

        //Submits form
        $form = $this->formFactory->create($formName, $character, ['csrf_protection' => false]);
        $form->submit($dataArray, false); //With false, only submitted fields are validated

        //Gets errors
        $errors = $form->getErrors();
        foreach ($errors as $error) {
            throw new LogicException('Error ' . get_class($error->getCause()) . ' --> ' . $error->getMessageTemplate() . ' ' . json_encode($error->getMessageParameters()));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function serializeJson($data)
    {
        $encoders = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($data) {
                return $data->getIdentifier();
            }
        ];
        $normalizers = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
        $serializer = new Serializer([new DateTimeNormalizer(), $normalizers], [$encoders]);

        return $serializer->serialize($data, 'json');
    }
}
