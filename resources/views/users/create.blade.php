@extends('layouts.app')

@section('title', 'Create User')

@section('content')
    <form method="POST" action="/store">
        @csrf
        <div class="question">
            <label for="name" <?= ($errors->has('name') ? 'class="error"' : '') ?> >Name:</label>
            <input type="text" name="name" value="{{ old('name') }}" <?= ($errors->has('name') ? 'class="error"' : '') ?> >
        </div>
        <div class="question">
            <label for="email" <?= ($errors->has('email') ? 'class="error"' : '') ?> >Email Address:</label>
            <input type="email" name="email" value="{{ old('email')}}" <?= ($errors->has('email') ? 'class="error"' : '') ?> >
        </div>
        <div class="question">
            <label for="hourly_rate" <?= ($errors->has('hourly_rate') ? 'class="error"' : '') ?> >Hourly Rate:</label>
            <input type="number" step="0.01" name="hourly_rate" value="{{ old('hourly_rate') }}" <?= ($errors->has('hourly_rate') ? 'class="error"' : '') ?> >
        </div>
        <div class="question">
            <label for="currency_id" <?= ($errors->has('currency_id') ? 'class="error"' : '') ?> >Currency: </label>
            <select <?= ($errors->has('currency_id') ? 'class="error"' : '') ?> name="currency_id">
                @foreach ($currencies as $currency)
                    @if ($currency->id == old('currency_id'))
                        <option value="{{ $currency->id }}" selected>{{ $currency->name }}</option>
                    @else
                        <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <input type="submit" class="button" value="Submit">
    </form>
@endsection
