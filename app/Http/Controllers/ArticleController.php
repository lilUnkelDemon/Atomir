<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Atomir\AtomirCore\Controller;
use Atomir\AtomirCore\Request;
use Rakit\Validation\Validator;

class ArticleController extends Controller
{

    public function indexAction()
    {
        return 'index of Page';
    }

    public function index(Request $request): string
    {
        $article = (new Article);

        // CREATE

//        $article->create(
//            [
//                'title' => 'mohsenoo',
//                'body' => 'this is mohsenoo article'
//            ]);


        // UPDATE

//        $article->update(
//            1,
//            [
//                'title' => 'hassanoo',
//                'body' => 'this is hassanoo article'
//            ]);


        // DELETE

//        $article->delete(3);

//        return "article test updated successfully";
//        return "article test created successfully";
//        return "article test deleted successfully";
//        var_dump($article->limit(2)->get());die;
//        var_dump($article->first());die;
//        var_dump($article->where('id', 2)->limit(5)->get());
//        var_dump($article->select('id','title')->find(2));
        var_dump($article->select('id','title')->find(2));
        die;
        return "crud test completed successfully";
    }

    public function create()
    {
        return $this->render('articles.create', [
            'title' => 'hello deamon',
            'auth' => true
        ]);
    }

    public function store(Request $request): ?string
    {
        $validation = $this->validate($request->all(),
            [
                'title' => 'required|min:8',
            ]);

        if ($validation->fails()) {
            $errors = $validation->errors();
            echo "<pre>";
            print_r($errors->firstOfAll());
            echo "</pre>";
            exit;
        } else {
            // validation passes
            echo "Success!";
        }

        var_dump($request->all());
        return $request->queries('id');
    }
}