<?php

namespace App\Controller;

use App\Entity\Document;
use App\Repository\DocumentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class DocumentController extends AbstractController
{
    protected $documentRepository;

    public function __construct(DocumentRepository $documentRepository)
    {
        $this->documentRepository = $documentRepository;
    }

    #[Route('/api/documents/', methods: ['GET'])]
    public function getDocumentsList(Request $request): JsonResponse
    {
        // если искать по пустому запросу, то тоже будут все документы
        // мб оставить только поиск, но это должно быть дольше
        if ($request->query->get('find')) {
            $documents = $this->documentRepository->findByValue($request->query->get('find'));
        } else {
            $documents = $this->documentRepository->getAllDocuments();
        }

        // $data = $serializer->serialize($documents, JsonEncoder::FORMAT);
        // return new JsonResponse($data, Response::HTTP_OK, [], true);
        return $this->json($documents);
    }

    #[Route('/api/documents/filter/', methods: ['GET'])]
    public function getFilterDocuments(Request $request): JsonResponse
    {
        $documents = $this->documentRepository->filterByFields(
            $request->query->get('name'),
            $request->query->get('author'),
            $request->query->get('date'),
            $request->query->get('state'),
            $request->query->get('text')
        );
        return $this->json($documents);
    }

    #[Route('/api/document/{id}/', methods: ['GET'])]
    public function getDocumentById(Request $request, $id): JsonResponse
    {
        $document = $this->documentRepository->getDocumentById($id);
        return $this->json($document);
    }

    #[Route('/api/document/', methods: ['PUT'])]
    public function createNewDocument(Request $request): JsonResponse
    {
        $params = json_decode($request->getContent());

        $document = new Document();
        $document->setName($params->name);
        $document->setAuthor($params->author);
        $document->setDate($params->date);
        $document->setState($params->state);
        $document->setText($params->text);

        $this->documentRepository->saveDocument($document);

        return $this->json(['success' => "ok"]);
    }

    #[Route('/api/document/{id}/', methods: ['PUT'])]
    public function editDocumentById(Request $request, $id): JsonResponse
    {
        $params = json_decode($request->getContent());

        $document = $this->documentRepository->getDocumentById($id);

        $document->setName($params->name);
        $document->setAuthor($params->author);
        $document->setDate($params->date);
        $document->setState($params->state);
        $document->setText($params->text);

        $this->documentRepository->updateDocument();

        return $this->json(['success' => "ok"]);
    }

    #[Route('/api/document/{id}/', methods: ['DELETE'])]
    public function deleteDocumentById(Request $request, $id): JsonResponse
    {
        $this->documentRepository->deleteDocumentById($id);
        return $this->json(['success' => "ok"]);
    }
}