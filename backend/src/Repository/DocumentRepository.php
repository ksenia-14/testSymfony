<?php

namespace App\Repository;

use App\Entity\Document;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\PseudoTypes\Numeric_;

/**
 * @extends ServiceEntityRepository<Document>
 */
class DocumentRepository extends ServiceEntityRepository
{
    private const viewItems = 10;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Document::class);
    }

    public function getDocumentById($id): ?Document
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getAllDocuments(): array
    {
        $documents = $this->findAll();
        return $documents;
    }

    public function findByValue($value): array
    {
        return $this->createQueryBuilder('d')
            ->andWhere("LOWER(d.name) LIKE :val")
            ->orWhere("LOWER(d.author) LIKE :val")
            ->orWhere("LOWER(d.date) LIKE :val")
            ->orWhere("LOWER(d.state) LIKE :val")
            ->orWhere("LOWER(d.text) LIKE :val")
            ->setParameter('val', "%" . mb_strtolower($value) . "%")
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(DocumentRepository::viewItems)
            ->getQuery()
            ->getResult()
        ;
    }

    public function filterByFields($name, $author, $date, $state, $text): array
    {
        return $this->createQueryBuilder('d')
            ->andWhere("LOWER(d.name) LIKE :name")
            ->andWhere("LOWER(d.author) LIKE :author")
            ->andWhere("LOWER(d.date) LIKE :date")
            ->andWhere("LOWER(d.state) LIKE :state")
            ->andWhere("LOWER(d.text) LIKE :text")
            ->setParameter('name', "%" . mb_strtolower($name) . "%")
            ->setParameter('author', "%" . mb_strtolower($author) . "%")
            ->setParameter('date', "%" . mb_strtolower($date) . "%")
            ->setParameter('state', "%" . mb_strtolower($state) . "%")
            ->setParameter('text', "%" . mb_strtolower($text) . "%")
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(DocumentRepository::viewItems)
            ->getQuery()
            ->getResult()
        ;
    }

    public function saveDocument(Document $document): void
    {
        $this->getEntityManager()->persist($document);
        $this->getEntityManager()->flush();
    }

    public function updateDocument(): void
    {
        $this->getEntityManager()->flush();
    }

    public function deleteDocumentById($id): void
    {
        $this->getEntityManager()->remove($this->getDocumentById($id));
        $this->getEntityManager()->flush();
    }

    //    /**
    //     * @return Document[] Returns an array of Document objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.id = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('d.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Document
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
