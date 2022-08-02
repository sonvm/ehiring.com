<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;



?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">E_HIRING</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor01">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link <?php if (Route::is('home')) echo "active"; ?>" href="/home">Home
            <span class="visually-hidden">(current)</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if (Route::is('careers*')) echo "active"; ?>" href="/careers">Careers</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if (Route::is('company*')) echo "active"; ?>" href="/company">Company</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if (Route::is('about*')) echo "active"; ?>" href="/about">About</a>
        </li>
      </ul>

      <ul class="nav">
        @guest
        <li class="nav-item fs-10 dropdown">
          <a class="nav-link" href="/register">Register</a>
        </li>
        <li class="nav-item fs-10 dropdown">
          <a class="nav-link fs-10 " aria-current="page" href="/login">Log In</a>
        </li>
        @else

        <?php



        $user_id = auth()->user()->id;
        $user_roles = DB::table('user_roles')->select('user_roles.role_id')->where('user_id', '=', $user_id)->join('roles', 'user_roles.role_id', '=', 'roles.id')->select('roles.name')->get()->toArray();

        $u_roles = [];
        foreach ($user_roles as $user_role) {
          $u_roles[] = $user_role->name;
        }

        ?>


        <li class="nav-item fs-10 dropdown">
          <a class="nav-link fs-10 dropdown-toggle <?php if (Route::is('manage*')) echo "active"; ?>" aria-current="page" data-bs-toggle="dropdown" href="#" aria-haspopup="true">Manage</a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="/my-account">My Account</a>
            <div class="dropdown-divider"></div>

            @if(in_array('applicant',$u_roles)||in_array('admin',$u_roles))
            <a class="dropdown-item" href="/cvs-manage-management">My CVs</a>
            @endif
            @if (in_array('employee',$u_roles)||in_array('admin',$u_roles))
            <a class="dropdown-item" href="/recruiting-news-management">My Recruiting News</a>
            <a class="dropdown-item" href="/hiring-board-management">My Hiring Board</a>
            @endif
            @if(in_array('admin',$u_roles))
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="/criterias">All Criterias</a>
            @endif
          </div>
        </li>
        <li class="nav-item fs-10 dropdown">
          <a class="nav-link fs-10" aria-current="page" href="/logout" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
            Log Out</a>
        </li>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
        </form>
        @endguest


      </ul>
    </div>



  </div>
</nav>