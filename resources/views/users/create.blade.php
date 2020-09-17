@extends('layouts.app')

@section('title', 'Create User')

@section('content')
    <form method="POST" action="/store">
        @csrf
        <div class="question">
            <label for="name" <?= ($errors->has('name') ? 'class="error"' : '') ?> >Name:</label>
            <input type="text" name="name" value="" <?= ($errors->has('name') ? 'class="error"' : '') ?> >
        </div>
        <div class="question">
            <label for="email" <?= ($errors->has('email') ? 'class="error"' : '') ?> >Email Address:</label>
            <input type="email" name="email" value="" <?= ($errors->has('email') ? 'class="error"' : '') ?> >
        </div>
        <div class="question">
            <label for="hourly_rate" <?= ($errors->has('hourly_rate') ? 'class="error"' : '') ?> >Hourly Rate:</label>
            <input type="number" step="0.01" name="hourly_rate" value="" <?= ($errors->has('hourly_rate') ? 'class="error"' : '') ?> >
        </div>

        <input type="submit" class="button" value="Submit">
    </form>
@endsection
