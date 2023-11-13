<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\NoteCreateRequest;
use App\Http\Requests\NoteGetOneRequest;
use App\Http\Resources\NoteResource;
use App\Models\Note;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class NoteController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    // Получение списка всех заметок(для админа)
    #[OA\Get(
        path: '/api/allNotes',
        summary: 'All Notes',
        security: [
            ['bearerAuth' => []],
        ],
        tags: ['Note'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'OK',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'bool'),
                        new OA\Property(property: 'data', properties: []),
                        new OA\Property(property: 'message', type: 'string'),
                    ],
                )),
            new OA\Response(
                response: 401,
                description: 'Unauthorised',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'bool'),
                        new OA\Property(property: 'message', type: 'string'),
                    ],
                )
            ),
        ]
    )]
    public function getAll(): JsonResponse
    {
        $notes = Note::all();

        return $this->sendResponse(NoteResource::collection($notes), 'Notes retrieved successfully.');
    }

    // Получение списка заметок(для пользователя)
    #[OA\Get(
        path: '/api/notes',
        summary: 'My Notes',
        security: [
            ['bearerAuth' => []],
        ],
        tags: ['Note'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'OK',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'bool'),
                        new OA\Property(property: 'data', properties: []),
                        new OA\Property(property: 'message', type: 'string'),
                    ],
                )),
            new OA\Response(
                response: 401,
                description: 'Unauthorised',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'bool'),
                        new OA\Property(property: 'message', type: 'string'),
                    ],
                )
            ),
        ]
    )]
    public function getMy(): JsonResponse
    {
        $result = Note::where('user_id', auth()->id())->get();

        return $this->sendResponse($result, 'Notes retrieved successfully.');
    }

    // Получение конкретной заметки
    #[OA\Get(
        path: '/api/note',
        summary: 'Get note',
        security: [
            ['bearerAuth' => []],
        ],
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(
                    required: ['id'],
                    properties: [
                        new OA\Property(property: 'id', type: 'integer'),
                    ]
                ),
            ),
        ),
        tags: ['Note'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'OK',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'bool'),
                        new OA\Property(property: 'data', properties: []),
                        new OA\Property(property: 'message', type: 'string'),
                    ],
                )),
            new OA\Response(
                response: 401,
                description: 'Unauthorised',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'bool'),
                        new OA\Property(property: 'message', type: 'string'),
                    ],
                )
            ),
        ]
    )]
    public function getOne(NoteGetOneRequest $request): JsonResponse
    {
        $result = Note::where('user_id', auth()->id())->find($request->id);

        return $this->sendResponse($result, 'Note retrieved successfully.');
    }

    // Создание новой заметки
    #[OA\Post(
        path: '/api/note',
        summary: 'Create note',
        security: [
            ['bearerAuth' => []],
        ],
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(
                    required: ['title', 'text'],
                    properties: [
                        new OA\Property(property: 'title', type: 'string'),
                        new OA\Property(property: 'text', type: 'string'),
                    ]
                ),
            ),
        ),
        tags: ['Note'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'OK',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'bool'),
                        new OA\Property(property: 'data', properties: []),
                        new OA\Property(property: 'message', type: 'string'),
                    ],
                )),
            new OA\Response(
                response: 401,
                description: 'Unauthorised',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'bool'),
                        new OA\Property(property: 'message', type: 'string'),
                    ],
                )
            ),
        ]
    )]
    public function create(NoteCreateRequest $request): JsonResponse
    {
        $note = new Note;
        $note->user_id = auth()->id();
        $note->title = $request->title;
        $note->text = $request->text;
        $note->save();

        return response()->json($note, 201);
    }

    // Обновление существующей заметки
    #[OA\Put(
        path: '/api/note',
        summary: 'Update note',
        security: [
            ['bearerAuth' => []],
        ],
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(
                    required: ['id', 'title', 'text'],
                    properties: [
                        new OA\Property(property: 'id', type: 'integer'),
                        new OA\Property(property: 'title', type: 'string'),
                        new OA\Property(property: 'text', type: 'string'),
                    ]
                ),
            ),
        ),
        tags: ['Note'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'OK',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'bool'),
                        new OA\Property(property: 'data', properties: []),
                        new OA\Property(property: 'message', type: 'string'),
                    ],
                )),
            new OA\Response(
                response: 401,
                description: 'Unauthorised',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'bool'),
                        new OA\Property(property: 'message', type: 'string'),
                    ],
                )
            ),
        ]
    )]
    public function update(NoteCreateRequest $request): JsonResponse
    {
        $note = Note::where('user_id', auth()->id())->find($request->id);
        $note->user_id = auth()->id();
        $note->title = $request->title;
        $note->text = $request->text;
        $note->save();

        return $this->sendResponse($note, 'Note created successfully.', 201);
    }

    // Удаление заметки
    #[OA\Delete(
        path: '/api/note',
        summary: 'Delete note',
        security: [
            ['bearerAuth' => []],
        ],
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(
                    required: ['id'],
                    properties: [
                        new OA\Property(property: 'id', type: 'integer'),
                    ]
                ),
            ),
        ),
        tags: ['Note'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'OK',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'bool'),
                        new OA\Property(property: 'data', properties: []),
                        new OA\Property(property: 'message', type: 'string'),
                    ],
                )),
            new OA\Response(
                response: 401,
                description: 'Unauthorised',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'bool'),
                        new OA\Property(property: 'message', type: 'string'),
                    ],
                )
            ),
        ]
    )]
    public function delete(NoteGetOneRequest $request): JsonResponse
    {
        $note = Note::where('user_id', auth()->id())->find($request->id);
        $note->delete();

        return $this->sendResponse(null, 'Note deleted successfully.', 204);
    }
}
