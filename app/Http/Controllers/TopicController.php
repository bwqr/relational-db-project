<?php


namespace App\Http\Controllers;


use App\DB\DBConnection;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    private $table = 'topic';

    public function getAdd()
    {
        return view('topic.add');
    }

    public function postTopic(Request $request, DBConnection $db)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        if ($db->checkExist($this->table, ['name' => $request->input('name')])) {
            dd('the record already exists');
        }

        $db->create($this->table, ['name' => $request->input('name')]);

        return redirect()->route('topic.home');
    }

    public function getEdit($id, DBConnection $db)
    {
        $topic = $db->findOrFail($this->table, $id);

        return  view('topic.edit')->with(['topic' => $topic]);
    }

    public function putTopic($id, Request $request, DBConnection $db)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $topic = $db->findOrFail($this->table, $id);

        $db->update($this->table, $id, ['name' => $request->input('name')]);

        return redirect()->route('topic.home');
    }

    public function deleteTopic($id, DBConnection $db)
    {
        $topic = $db->findOrFail($this->table, $id);

        $db->delete($this->table, $id);

        return redirect()->route('topic.home');
    }

    public function getPapers($id, DBConnection $db)
    {
        $topic= $db->findOrFail($this->table, $id);

        $papers = [];

        $papers['data'] = $db->hasMany('paper', 'paper_has_topic', $this->table, $id);

        $papers['columns'] = $db->getColumns('paper');

        return view('topic.papers')->with(['papers' => $papers, 'topic' => $topic]);
    }

    public function getSota($id, DBConnection $db)
    {
        $topic= $db->findOrFail($this->table, $id);

        $query = "select p.* from paper p 
                    where p.result = (
                        select MAX(paper.result) from paper 
                            join paper_has_topic on paper.id = paper_has_topic.paper_id 
                            join topic on paper_has_topic.topic_id = topic.id 
                            where topic.id = $id and paper.id = p.id
                        ) ORDER BY result DESC LIMIT 1;";

        $papers['data'] = $db->exec($query);
        $papers['columns'] = $db->getColumns('paper');

        return view('topic.sota-paper')->with(['papers' => $papers, 'topic' => $topic]);
    }

    public function getTopic($id, DBConnection $db)
    {
        $topic = $db->findOrFail($this->table, $id);

        return view('topic.topic')->with(['topic' => $topic]);
    }

    public function index(DBConnection $db)
    {
        $topics['data'] = $db->all($this->table);

        $topics['columns'] = $db->getColumns($this->table);

        return view('topic.home')->with(['topics' => $topics]);
    }
}
