<?php

declare(strict_types=1);

namespace Knp\DoctrineBehaviors\Tests\Fixtures\Entity\Sluggable;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\SluggableInterface;
use Knp\DoctrineBehaviors\Exception\ShouldNotHappenException;
use Knp\DoctrineBehaviors\Model\Sluggable\SluggableTrait;

/**
 * @ORM\Entity
 */
class SluggableMultiEntity implements SluggableInterface
{
    use SluggableTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private int $id;

    /**
     * @ORM\Column(type="string")
     */
    private ?string $name = null;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface|\DateTime $dateTime;

    public function __construct()
    {
        $this->dateTime = (new DateTime())->modify('-1 year');
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        if ($this->name === null) {
            throw new ShouldNotHappenException();
        }

        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDate(): DateTimeInterface
    {
        return $this->dateTime;
    }

    public function setDate(DateTimeInterface $dateTime): void
    {
        $this->dateTime = $dateTime;
    }

    /**
     * @return string[]
     */
    public function getSluggableFields(): array
    {
        return ['name', 'title'];
    }

    public function getTitle(): string
    {
        return 'title';
    }

    /**
     * @return mixed|string
     */
    public function generateSlugValue(array $values)
    {
        $sluggableText = implode(' ', $values);
        $sluggableText = str_replace(' ', '+', $sluggableText);

        return strtolower($sluggableText);
    }
}
