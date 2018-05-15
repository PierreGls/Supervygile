<?php

namespace App\Repository;

use App\Entity\Projet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Projet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Projet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Projet[]    findAll()
 * @method Projet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjetRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Projet::class);
    }

//    /**
//     * @return Projet[] Returns an array of Projet objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Projet
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
	public function findByGroupe($groupe_id): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.groupe_id = :val')
            ->setParameter('val', $groupe_id)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
	
	public function findAll(): array
    {
        $entityManager = $this->getEntityManager();

		$query = $entityManager->createQuery(
			'SELECT p
			FROM App\Entity\Projet p'
		);

		// returns an array of Product objects
		return $query->execute();
    }
	
	public function getCount(): int
    {
        $entityManager = $this->getEntityManager();

		$query = $entityManager->createQuery(
			'SELECT COUNT(p)
			FROM App\Entity\Projet p
			'
		);

		// returns an int of Product objects
		$result = $query->execute();
		return $result[0][1];
    }
}
