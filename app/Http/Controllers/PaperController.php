<?php


namespace App\Http\Controllers;


use App\DB\DBConnection;
use Illuminate\Http\Request;

class PaperController extends Controller
{
    private $table = 'paper';

    public function getAdd(DBConnection $db)
    {
        $authors = $db->all('author');

        $topics = $db->all('topic');

        return view('paper.add')->with(['authors' => $authors, 'topics' => $topics]);
    }

    public function postPaper(Request $request, DBConnection $db)
    {
        $this->validate($request, [
            'title' => 'required',
            'abstract' => 'required',
            'result' => 'required'
        ]);

        if ($db->checkExist($this->table, ['title' => $request->input('title')])) {
            dd('the record already exists');
        }

        $last_id = $db->create($this->table, [
            'title' => $request->input('title'),
            'abstract' => $request->input('abstract'),
            'result' => $request->input('result')
        ]);

        $all = $request->all();
        $keys = array_keys($all);
        $author_keys = preg_grep('/author_(.*?)/', $keys);
        $topic_keys = preg_grep('/topic_(.*?)/', $keys);

        foreach ($author_keys as $author_key) {
            $author_id = (int) explode('_', $author_key)[1];

            $db->create('paper_has_author', ['paper_id' => $last_id, 'author_id' => $author_id]);
        }

        foreach ($topic_keys as $topic_key) {
            $topic_id = (int) explode('_', $topic_key)[1];

            $db->create('paper_has_topic', ['paper_id' => $last_id, 'topic_id' => $topic_id]);
        }

        return redirect()->route('paper.home');
    }

    public function searchByKeyword(Request $request, DBConnection $db)
    {
        $this->validate($request, [
            'keyword' => 'required'
        ]);

        $keyword = $request->input('keyword');

        $query = "SELECT paper.* from paper WHERE title LIKE '%$keyword%' OR abstract LIKE '%$keyword%';";

        $papers['data'] = $db->exec($query);
        $papers['columns'] = $db->getColumns($this->table);

        return view('paper.search')->with(['papers' => $papers, 'keyword' => $keyword]);
    }

    public function getEdit($id, DBConnection $db)
    {
        $paper = $db->findOrFail($this->table, $id);

        $authors = $db->hasMany('author', 'paper_has_author', $this->table, $id);

        $topics = $db->hasMany('topic', 'paper_has_topic', $this->table, $id);

        $all_authors = $db->all('author');

        $all_topics = $db->all('topic');

        foreach ($all_authors as $key => $author) {
            $all_authors[$key]['exist'] = array_search($author['id'], array_column($authors, 'id')) !== false;
        }

        foreach ($all_topics as $key => $topic) {
            $all_topics[$key]['exist'] = array_search($topic['id'], array_column($topics, 'id')) !== false;
        }

        return view('paper.edit')->with(['paper' => $paper, 'authors' => $all_authors, 'topics' => $all_topics]);
    }
    public function putPaper($id, Request $request, DBConnection $db)
    {
        $this->validate($request, [
            'title' => 'required',
            'abstract' => 'required',
            'result' => 'required'
        ]);

        $paper = $db->findOrFail($this->table, $id);

        $db->deleteWhere('paper_has_topic', ['paper_id' => $paper['id']]);
        $db->deleteWhere('paper_has_author', ['paper_id' => $paper['id']]);

        $db->update($this->table, $paper['id'], [
            'title' => $request->input('title'),
            'abstract' => $request->input('abstract'),
            'result' => $request->input('result')
        ]);

        $all = $request->all();
        $keys = array_keys($all);
        $author_keys = preg_grep('/author_(.*?)/', $keys);
        $topic_keys = preg_grep('/topic_(.*?)/', $keys);

        foreach ($author_keys as $author_key) {
            $author_id = (int) explode('_', $author_key)[1];

            $db->create('paper_has_author', ['paper_id' => $paper['id'], 'author_id' => $author_id]);
        }

        foreach ($topic_keys as $topic_key) {
            $topic_id = (int) explode('_', $topic_key)[1];

            $db->create('paper_has_topic', ['paper_id' => $paper['id'], 'topic_id' => $topic_id]);
        }

        return redirect()->route('paper.home');
    }

    public function deletePaper($id, DBConnection $db)
    {
        $paper = $db->findOrFail($this->table, $id);

        $db->delete($this->table, $id);

        return redirect()->route('paper.home');
    }

    public function getPaper($id, DBConnection $db)
    {
        $paper = $db->findOrFail($this->table, $id);

        return view('paper.paper')->with(['paper' => $paper]);
    }

    public function index(DBConnection $db)
    {
        $papers['data'] = $db->all($this->table, 'id, title');

        $papers['columns'] = $db->getColumns($this->table);
        if (($key = array_search('abstract', $papers['columns'])) !== false) {
            unset($papers['columns'][$key]);
        }

        return view('paper.home')->with(['papers' => $papers]);
    }
}
