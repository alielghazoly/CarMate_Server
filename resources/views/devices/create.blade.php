@extends('layouts.dashboard')

@section('content')
<div class="box box-primary">
      <div class="box-header">
        <h3 class="box-title">Create Devices</h3>
      </div>
      <div class="box-body">
	  <form class="row">
     
      <div class="add-store-input-div col-md-3 col-sm-6">
        <label>Device Type </label>
        <select>
          <option selected hidden disabled>--choose--</option>
          <option>device</option>
          <option>part</option>
        </select>
      </div>
	  <div class="add-store-input-div col-md-3 col-sm-6">
        <label>Part Type </label>
        <select>
          <option selected hidden disabled>--choose--</option>
          <option>finger print</option>
          <option>cut</option>
        </select>
      </div>
     
	  
      <div class="add-store-input-div col-md-3 col-sm-6">
        <label>Number Of Devices</label>
        <input type="text" />
      </div>
	  <div class="add-store-input-div col-md-3 col-sm-6">
        <label> Device Version  </label>
        <input type="text" />
      </div>
    
      <button type="submit" class="add-store-submitBtn">Create Devices</button>
    </form>
        <div class="clearfix"></div>
      </div>
    </div>


@endsection
