@extends('layout')

@section('content')
    <h2 class="page-title">COMPANY SETTINGS</h2>
    <form class="row g-3" action="#" method="post" id="companySetting">
        <div class="col-lg-6 mb-3">
            <label class="form-check-label" for="timocomId">TIMOCOM ID:</label>
            <input type="number" class="form-control" placeholder="TIMOCOM ID" id="timocomId" name="timocomId">
            <div class="valid-feedback"></div>
        </div>
        <div class="col-lg-6 mb-3">
            <label class="form-check-label" for="companyName">Company name:</label>
            <input type="text" class="form-control" placeholder="Company name" id="companyName" name="companyName">
            <div class="valid-feedback"></div>
        </div>
        <div class="col-lg-6 mb-3">
            <label class="form-check-label" for="contactPerson">Contact person:</label>
            <input type="text" class="form-control" placeholder="Contact person" id="contactPerson" name="contactPerson">
            <div class="valid-feedback"></div>
        </div>
        <div class="col-lg-6 mb-3">
            <label class="form-check-label" for="phone">Phone:</label>
            <input type="text" class="form-control" placeholder="Phone" id="phone" name="phone">
            <div class="valid-feedback"></div>
        </div>
        <div class="col-lg-6 mb-3">
            <label class="form-check-label" for="phone">Email:</label>
            <input type="email" class="form-control" placeholder="Email" id="email" name="email">
            <div class="valid-feedback"></div>
        </div>
        <div class="col-12 text-end">
            <button class="btn btn-primary col-auto">Save Company setting</button>
        </div>
    </form>
@endsection
