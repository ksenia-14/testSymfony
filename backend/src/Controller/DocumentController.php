<?php

namespace App\Controller;

use App\Entity\Document;
use App\Repository\DocumentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class DocumentController extends AbstractController
{
    protected $documentRepository;

    public function __construct(DocumentRepository $documentRepository)
    {
        $this->documentRepository = $documentRepository;
    }

    #[Route('/api/documents/', methods: ['GET'])]
    public function getDocumentsList(Request $request, SerializerInterface $serializer): JsonResponse
    {
        // если искать по пустому запросу, то тоже будут все документы
        // мб оставить только поиск, но это должно быть дольше
        if ($request->query->get('find')) {
            $documents = $this->documentRepository->findByValue($request->query->get('find'));
        } else {
            $documents = $this->documentRepository->getAllDocuments();
        }

        $data = $serializer->serialize($documents, JsonEncoder::FORMAT);
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    #[Route('/api/documents/filter/', methods: ['GET'])]
    public function getFilterDocuments(Request $request, SerializerInterface $serializer): JsonResponse
    {
        $documents = $this->documentRepository->filterByFields(
            $request->query->get('name'),
            $request->query->get('author'),
            $request->query->get('date'),
            $request->query->get('state'),
            $request->query->get('text')
        );
        $data = $serializer->serialize($documents, JsonEncoder::FORMAT);
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    #[Route('/api/document/{id}/', methods: ['GET'])]
    public function getDocumentById(Request $request, SerializerInterface $serializer, $id): JsonResponse
    {
        $document = $this->documentRepository->getDocumentById($id);
        $data = $serializer->serialize($document, JsonEncoder::FORMAT);
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    #[Route('/api/document/', methods: ['PUT'])]
    public function createNewDocument(Request $request, SerializerInterface $serializer): JsonResponse
    {
        $params = json_decode($request->getContent());

        $document = new Document();
        $document->setName($params->name);
        $document->setAuthor($params->author);
        $document->setDate($params->date);
        $document->setState($params->state);
        $document->setText($params->text);

        $this->documentRepository->saveDocument($document);

        $data = $serializer->serialize(['success' => "ok"], JsonEncoder::FORMAT);
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    #[Route('/api/document/{id}/', methods: ['PUT'])]
    public function editDocumentById(Request $request, SerializerInterface $serializer, $id): JsonResponse
    {
        $params = json_decode($request->getContent());

        $document = $this->documentRepository->getDocumentById($id);

        $document->setName($params->name);
        $document->setAuthor($params->author);
        $document->setDate($params->date);
        $document->setState($params->state);
        $document->setText($params->text);

        $data = $serializer->serialize(['success' => "ok"], JsonEncoder::FORMAT);
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    #[Route('/api/document/{id}/', methods: ['DELETE'])]
    public function deleteDocumentById(Request $request, SerializerInterface $serializer, $id): JsonResponse
    {
        $this->documentRepository->deleteDocumentById($id);
        $data = $serializer->serialize(['success' => "ok"], JsonEncoder::FORMAT);
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }
}