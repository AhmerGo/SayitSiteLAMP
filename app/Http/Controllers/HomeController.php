<?php
  
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {

	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function get_messages() {
		$messages= DB::select("SELECT CONVERT_TZ(ts,@@session.time_zone, '-05:00') AS ts, topic, message FROM messages ORDER BY ts DESC LIMIT 10");
		$topics= DB::select("SELECT topic, COUNT(topic) FROM messages GROUP BY topic ORDER BY COUNT(topic) DESC, topic");
		return view('home', ['messages' => $messages, 'topics' => $topics]);
	}

	public function trim_topic($topic) {
		$topic= preg_replace("/ {2,}/",' ', $topic);
		$topic= preg_replace("/[^a-zA-Z0-9]_ ]/",'', $topic);
		return ucwords($topic);
	}

	public function post_message(Request $request) {
		$data= array_map('trim', $request->all());
		$data['new-topic']= $this->trim_topic($data['new-topic']);
		$data['existing-topic']= isset($data['existing-topic']) ? $this->trim_topic($data['existing-topic']) : '';
		$data['topic']= $data['new-topic'] == '' ? $data['existing-topic'] : $data['new-topic'];
		$request->merge($data);

		$data= $request->validate([
			'message' => 'required|max:500',
			'topic' => 'required|max:100'
		]);
		
		DB::insert("INSERT INTO messages (topic, message) VALUES (?, ?)", [$request->topic, $request->message]);
		return $this->get_messages();
	}
}
