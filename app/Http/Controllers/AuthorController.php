<?php


namespace App\Http\Controllers;


use App\DB\DBConnection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthorController extends Controller
{
    private $table = 'author';

    public function getAdd()
    {
        return view('author.add');
    }

    public function postAuthor(Request $request, DBConnection $db)
    {
        $this->validate($request, [
            'name' => 'required',
            'surname' => 'required'
        ]);

        $name = $request->input('name');
        $surname = $request->input('surname');

        if ($db->checkExist($this->table, ['name' => $name, 'surname' => $surname])) {
            dd('the record already exists');
        }

        $db->create($this->table, ['name' => $name, 'surname' => $surname]);

        return redirect()->route('author.home');
    }

    public function getEdit($id, DBConnection $db)
    {
        $author = $db->findOrFail($this->table, $id);

        return view('author.edit')->with(['author' => $author]);
    }

    public function putAuthor($id, DBConnection $db, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'surname' => 'required'
        ]);

        $author = $db->findOrFail($this->table, $id);

        $db->update($this->table, $id, ['name' => $request->input('name'), 'surname' => $request->input('surname')]);

        return redirect()->route('author.home');
    }

    public function deleteAuthor($id, DBConnection $db)
    {
        $author = $db->findOrFail($this->table, $id);

        $db->delete($this->table, $id);

        return redirect()->route('author.home');
    }

    public function getPapers($id, DBConnection $db)
    {
        $author = $db->findOrFail($this->table, $id);
        $papers = [];
        $papers['data'] = $db->hasMany('paper', 'paper_has_author', $this->table, $id);

        $papers['columns'] = $db->getColumns('paper');

        return view('author.papers')->with(['papers' => $papers, 'author' => $author]);
    }

    public function getAuthorsRankedBySota(DBConnection $db)
    {
        $topic_sotas = "select MAX(paper.result), topic.id  from paper 
                           join paper_has_topic on paper.id = paper_has_topic.paper_id 
                           join topic on paper_has_topic.topic_id = topic.id 
                           GROUP BY topic.id";

        $papers_ids = "select p.id from paper as p 
                                join paper_has_topic pha1 on p.id = pha1.paper_id 
                                join topic t1 on pha1.topic_id = t1.id 
                                where (p.result, t1.id) in ($topic_sotas)";

        $author_query = "select author.* from author join paper_has_author pha on pha.author_id = author.id
                        where pha.paper_id in ($papers_ids);";

        $sota_authors = $db->exec($author_query);

        $res = array_reduce($sota_authors, function ($res, $cur) {
            $index = array_search($cur['id'], array_column($res, 'id'));
            if ($index !== false) {
                $res[$index]['rank']++;
            } else {
                $cur['rank'] = 1;
                $res[] = $cur;
            }

            return $res;
        }, []);

        $authors = [];

        $authors['data'] = $res;
        $authors['columns'] = $db->getColumns($this->table);
        $authors['columns'][] = 'Rank';

        return view('author.ranks')->with(['authors' => $authors]);
    }

    public function getCoAuthors($id, DBConnection $db)
    {
        $author = $db->findOrFail($this->table, $id);

        $name = $author['name'];
        $surname = $author['surname'];

        $query = "CALL sota.COAUTHORS('$name', '$surname');";

        $coauthors['data'] = $db->exec($query);

        $coauthors['columns'] = $db->getColumns($this->table);

        return view('author.coauthors')->with(['coauthors' => $coauthors, 'author' => $author]);
    }

    public  function getAuthor($id, DBConnection $db)
    {
        $author = $db->findOrFail($this->table, $id);

        return view('author.author')->with(['author' => $author]);
    }

    public function index(DBConnection $db)
    {
        $authors['data'] = $db->all($this->table);

        $authors['columns'] = $db->getColumns($this->table);

        return view('author.home')->with(['authors' => $authors]);
    }
}
