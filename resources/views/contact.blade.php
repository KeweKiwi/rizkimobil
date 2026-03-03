@extends('layouts.app')

@section('content')
<h1>Contact Us</h1>

@if (session('success'))
  <div>{{ session('success') }}</div>
@endif

@if ($errors->any())
  <ul>
    @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
  </ul>
@endif

<form method="POST" action="{{ route('contact.store') }}">
  @csrf

  <input name="name" placeholder="Name" value="{{ old('name') }}"><br>
  <input name="email" placeholder="Email" value="{{ old('email') }}"><br>
  <input name="subject" placeholder="Subject" value="{{ old('subject') }}"><br>
  <textarea name="message">{{ old('message') }}</textarea><br>

  <button type="submit">Send</button>
</form>
@endsection
