@extends('layouts.main')
@section('content')
<h1>Say It!&trade;</h1>
<div class="grid_6">
	<h2>What's Been Said ...</h2>
	<div id="beensaid">
			@foreach ($messages as $message)
				<section>
					<span class="ts">{{$message->ts}}</span>
					<span class="topic">{{$message->topic}}</span>
					{{$message->message}}
				</section>
			@endforeach
	</div>
	<button id="update">Update!</button>
</div>

<div class="grid_6">
	<h2>Say It Yourself ...</h2>
	<div id="sayit">
		<form method="post" action="{{ action('HomeController@post_message') }}">
			<label>Topic:</label>
			<select name="existing-topic">
				<?php
				usort($topics, function ($a, $b) { return strcmp($a->topic, $b->topic); });
				foreach ($topics as $topic)
					echo "	<option>$topic->topic</option>\n";
				?>
			</select>
			or
			<input type="text" name="new-topic" value="{{old('new-topic')}}"/>
			@if ($errors->has('topic'))
				<div class="error">Topic names are limited to 100 characters</div>
				<div class="clear"></div>
			@endif
			@if ($errors->has('message'))
				<div class="error">Post Failed: Message cannot be blank and is limited to 500 characters</div>
			@endif
			<div class="clear"></div>
			<label>Message (limit 500 chars)</label><br/>
			<textarea name="message">{{old('message')}}</textarea>
			<button>Say It!</button>
			@csrf
		</form>
	</div>
</div>
@endsection
