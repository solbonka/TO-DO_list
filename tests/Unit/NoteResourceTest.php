<?php

namespace Tests\Unit;

use App\Models\Note;
use Tests\TestCase;
use App\Http\Resources\NoteResource;
use Illuminate\Http\Request;

class NoteResourceTest extends TestCase
{
    public function testToArrayMethodReturnsCorrectArray()
    {
        $note = new Note();
        $note->id = 1;
        $note->user_id = 1;
        $note->title = 'Test Title';
        $note->text = 'Test Text';
        $note->created_at = '2021-01-01 00:00:00';
        $note->updated_at = '2021-02-01 00:00:00';

        $request = new Request();

        $resource = new NoteResource($note);

        $expectedArray = [
            'id' => 1,
            'user_id' => 1,
            'title' => 'Test Title',
            'text' => 'Test Text',
            'created_at' => '01/01/2021',
            'updated_at' => '01/02/2021',
        ];

        var_dump($expectedArray);
        $this->assertEquals($expectedArray, $resource->toArray($request));
    }
}
