{{-- @section('title', $question->title)
@extends('layouts.app')
@section('content') --}}
<div class="flex space-x-5">
  <div class="w-3/4">
    <div class="p-3 mb-5 shadow-xl rounded-md bg-white">
      <h1 class="font-medium text-xl">{{$question->title}}</h1>
      <p class="text-gray-800 my-1">{{$question->description}}</p>
      <div class="inline mx-4">
        <button wire:click.prevent="upVoteQuestion()"">
          <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-10 h-10 @if($question->liked) text-primary @else text-gray-400 @endif" viewBox="0 0 16 16">
            <path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
          </svg>
        </button>
        <span class="text-xl mr-2 my-auto">{{$question->totalUpVote}}</span>
        <button wire:click.prevent="downVoteQuestion()">
          <svg xmlns="http://www.w3.org/2000/svg"  fill="currentColor" class="h-10 w-10 @if($question->disliked) text-primary @else text-gray-400 @endif" viewBox="0 0 16 16">
            <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
          </svg>
        </button>
        <span class="text-xl">{{$question->totalDownVote}}</span>
          <p class="text-sm">
          <span>{{$this->answers->count()}} answers</span>
          <span class="text-gray-600">viewed </span><span>{{$question->views}} times</span>
          <span class="text-gray-600">asked </span><span>{{$question->created_at->diffForHumans()}}</span>
          @if($question->created_at!=$question->updated_at)
          <span class="text-gray-600">modified </span><span>{{$question->updated_at->diffForHumans()}}</span>
          @endif
       </p>
      </div>
    </div>
    @if($question->voting)
        <div class="fixed z-20 top-1/4 left-1/4 bg-white p-10 flex flex-col justify-center items-center rounded-xl">
        <button wire:click="closeModal()" class="absolute -top-1 -right-1 text-4xl text-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
            </svg>
        </button>
        <p class="text-2xl">want to upvote/downvote this question ?</p>
        <p class="text-xl text-gray-600">sign in to upvote/downvote this question</p>
        <p class="m-auto"><a href="/login" class="text-2xl text-primary">sign in</a></p>
        </div>
        <div wire:click="closeModal()" class="absolute -inset-full opacity-50 bg-black z-10"></div>
    @endif
    @auth
    <div>
      <h1 class="text-2xl">submit your answer here</h1>
      <form wire:submit="answer()" class="">
      <textarea wire:model="answer" required class="w-full h-32 my-1 rounded-md shadow-xl border border-gray-300 focus:border-primary focus:ring-primary">
      </textarea>
      <button type="submit" wire:loading.attr="disabled" class="block cursor-pointer font-semibold text-white bg-primary py-2.5 px-10 rounded-md focus:outline-none focus:underline transition ease-in-out duration-150">
        Submit
        {{-- <span wire:loading.remove>Submit</span>
        <span wire:loading>Please Wait</span> --}}
      </button>
      </form>
      @else
      <p><a href="/login" class="text-primary text-xl">login</a> to answer  this question</p>
    </div>
    @endauth
      @if($this->answers->count())
        <p class="my-1 text-xl">{{$this->answers->count()}} answers found</p>
      @endif
      @forelse ($this->answers as $answer)
      <div class="flex my-5 bg-gray-100 rounded-md shadow-xl">
        <div class="flex flex-col items-center">
            <button wire:click.prevent="upVoteAnswer({{$answer->id}})"">
              <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-10 h-10 @if($answer->liked) text-primary @else text-gray-400 @endif" viewBox="0 0 16 16">
                <path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
              </svg>
            </button>
            {{-- @isset($record)
                <img src="/storage/profile/useravatar.jpeg" alt="" class="h-12 w-12 rounded-full my-1">
            @else
                <div class="h-12 w-12 rounded-full my-1 text-white bg-primary flex justify-center items-center text-2xl">{{$this->getFirstChar()}}</div>
            @endisset --}}
            <span class="text-xl">{{$this->totalVote($answer->id)}}</span>
            <button wire:click.prevent="downVoteAnswer({{$answer->id}})">
              <svg xmlns="http://www.w3.org/2000/svg"  fill="currentColor" class="h-10 w-10 @if($answer->disliked) text-primary @else text-gray-400 @endif" viewBox="0 0 16 16">
                <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
              </svg>
            </button>
        </div>
        <div class="p-2">
            <p>{{$answer->body}}</p>
            <p class="text-gray-500">{{$answer->updated_at->diffForHumans()}}</p>
        </div>
      </div>
      @empty
        <p>No answers found</p>
      @endforelse
    </div>
  </div>
  <div class="w-1/4">
    <a href="{{ route('questions.create') }}" class="font-semibold text-white bg-primary py-2.5 px-10 rounded-md focus:outline-none focus:underline transition ease-in-out duration-150">ask</a>
  </div>
</div>
{{-- @endsection --}}
