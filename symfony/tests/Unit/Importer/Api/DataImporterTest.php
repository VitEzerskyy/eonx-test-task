<?php

declare(strict_types=1);

namespace App\Tests\Unit\Importer\Api;

use App\Entity\Customer;
use App\Importer\Api\DataImporter;
use App\Provider\ProviderInterface;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DataImporterTest extends TestCase
{
    private MockObject $providerInterface;
    private MockObject $entityManager;
    private MockObject $customerRepository;
    private DataImporter $dataImporter;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->providerInterface = $this->createMock(ProviderInterface::class);
        $this->customerRepository = $this->createMock(CustomerRepository::class);
        $this->dataImporter = new DataImporter(
            $this->providerInterface,
            $this->entityManager,
            $this->customerRepository
        );
    }

    public function testOnEmptyData(): void
    {
        $this->expectException(\RuntimeException::class);
        $data = [];

        $this->providerInterface
            ->expects($this->once())
            ->method('getData')
            ->willReturn($data);

        $this->dataImporter->import();
    }

    public function testOnEmptyCustomers(): void
    {
        $data = $this->getData();

        $this->providerInterface
            ->expects($this->once())
            ->method('getData')
            ->willReturn($data);

        $this->customerRepository
            ->expects($this->once())
            ->method('findAll')
            ->willReturn([]);

        $this->entityManager
            ->expects($this->exactly(2))
            ->method('persist')
            ->willReturnSelf();

        $this->entityManager
            ->expects($this->once())
            ->method('flush')
            ->willReturnSelf();

        $this->dataImporter->import();
    }

    public function testOnTheSameEmails(): void
    {
        $data = $this->getData();
        $customers = [$this->createCustomer($data[0]), $this->createCustomer($data[1])];

        $this->providerInterface
            ->expects($this->once())
            ->method('getData')
            ->willReturn($data);

        $this->customerRepository
            ->expects($this->once())
            ->method('findAll')
            ->willReturn($customers);

        $this->entityManager
            ->expects($this->exactly(2))
            ->method('persist')
            ->willReturnSelf();

        $this->entityManager
            ->expects($this->once())
            ->method('flush')
            ->willReturnSelf();

        $this->dataImporter->import();
    }

    public function testOnTheDifferentEmails(): void
    {
        $data = $this->getData();
        $customerOne = (new Customer())
            ->setFirstName('John')
            ->setLastName('Fruschiante')
            ->setEmail('john@test.com')
            ->setCountry('Australia')
            ->setUsername('john')
            ->setGender('male')
            ->setCity('Sydney')
            ->setPhone('03-0932-2913');
        $customerTwo = (new Customer())
            ->setFirstName('Kate')
            ->setLastName('Kil')
            ->setEmail('kate@test.com')
            ->setCountry('Australia')
            ->setUsername('kate')
            ->setGender('female')
            ->setCity('Sydney')
            ->setPhone('03-0977-2913');

        $this->providerInterface
            ->expects($this->once())
            ->method('getData')
            ->willReturn($data);

        $this->customerRepository
            ->expects($this->once())
            ->method('findAll')
            ->willReturn([$customerOne, $customerTwo]);

        $this->entityManager
            ->expects($this->exactly(2))
            ->method('persist')
            ->willReturnSelf();

        $this->entityManager
            ->expects($this->once())
            ->method('flush')
            ->willReturnSelf();

        $this->dataImporter->import();
    }

    private function getData(): array
    {
        return [
        [
            'gender' => 'female',
            'name' => [
                'title' => 'Ms',
                'first' => 'Mary',
                'last' => 'Jane'
            ],
            'location' => [
                'city' => 'Melbourne',
                'country' => 'Australia'
            ],
            'email' => 'test@test.com',
            'login' => [
                'username' => 'test',
            ],
            'phone' => '04-5263-1403'
        ],
        [
            'gender' => 'male',
            'name' => [
                'title' => 'Mr',
                'first' => 'Max',
                'last' => 'Doe'
            ],
            'location' => [
                'city' => 'Townsville',
                'country' => 'Australia'
            ],
            'email' => 'test1@test.com',
            'login' => [
                'username' => 'test1',
            ],
            'phone' => '04-9030-7731'
        ],
        ];
    }

    private function createCustomer(array $customerData): Customer
    {
        return (new Customer())
            ->setFirstName($customerData['name']['first'])
            ->setLastName($customerData['name']['last'])
            ->setEmail($customerData['email'])
            ->setCountry($customerData['location']['country'])
            ->setUsername($customerData['login']['username'])
            ->setGender($customerData['gender'])
            ->setCity($customerData['location']['city'])
            ->setPhone($customerData['phone']);
    }
}
