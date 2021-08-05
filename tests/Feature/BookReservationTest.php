<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Book;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_added_to_the_library()
    {
        // Setup
        $this->withoutExceptionHandling();


        // Do the thing
        $response = $this->post('/books', [
            'title' => 'Cool Book Title',
            'author' => 'Graham J Kerr',
        ]);

        // Test the result
        $response->assertOk();
        $this->assertCount(1, Book::all());

    }

    /** @test */
    public function a_title_is_required()
    {
        // Setup

        // Do the thing
        $response = $this->post('/books', [
            'title' => '',
            'author' => 'Graham J Kerr',
        ]);

        // test
        $response->assertSessionHasErrors('title');
    }

    /** @test */
    public function an_author_is_required()
    {
        // Setup

        // Do the thing
        $response = $this->post('/books', [
            'title' => 'Cool New Book',
            'author' => '',
        ]);

        // test
        $response->assertSessionHasErrors('author');
    }

    /** @test */
    public function a_book_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/books', [
            'title' => 'Cool New Book',
            'author' => 'Graham J Kerr',
        ]);

        $book = Book::first();

        $response = $this->patch('/books/' . $book->id, [
            'title' => 'Cool New Book 2nd Ed',
            'author' => 'Jane A Kerr',
        ]);

        $this->assertEquals('Cool New Book 2nd Ed', Book::first()->title);
        $this->assertEquals('Jane A Kerr', Book::first()->author);
    }
}
