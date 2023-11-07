<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Genesis School System">
    <meta name="keywords"
        content="Genesis School, School Integrated System, school software, school management, albogast, Albogast Kiyogoma, Albolink">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/logoNEW.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/logoNEW.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/logoNEW.png">
    <title>Genesis Schools Tanzania</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <script src="{{ mix('js/app.js') }}" defer></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/tailwind.output.css') }}" />

    <script src="{{ URL::asset('assets/js/jquery-3.6.3.min.js') }}"></script>
    <link href="{{ URL::asset('assets/css/select2.min.css') }}" rel="stylesheet" />
    <script src="{{ URL::asset('assets/css/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/js/toastr.min.js') }}"></script>
    <link href="{{ URL::asset('assets/css/toastr.min.css') }}" rel="stylesheet">
    <script src="{{ URL::asset('assets/js/alpine.min.js') }}" defer></script>
    <script src="{{ URL::asset('assets/js/init-alpine.js') }}"></script>
</head>
<?php
$thispage = request()->segment(1);
 $current_page = '<span class="absolute inset-y-0 left-0 w-1 bg-red-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>';
?>
<body>
  <div class="flex h-screen dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen }">
      <!-- Desktop sidebar -->
      <aside id="topnav"
          class="z-20 hidden w-64 overflow-y-auto bg-gray-800 dark:bg-gray-800 md:block flex-shrink-0">
          <div class="py-1 text-white dark:text-gray-400">
              <a class="ml-10 text-lg font-bold text-white dark:text-gray-200" href="{{ url('/home') }}">
                  <img aria-hidden="true" class="h-full ml-6 dark:hidden" src="{{ asset('NIT_logoBg.png') }}" alt=""
                      width="60%" />
              </a>
              <ul class="mt-4 text-gray-100">
                      <li class="relative px-6 py-1">
                          @if($thispage == 'home' ||$thispage == 'dashboard' || $thispage == '')
                           <?=$current_page?>
                          @endif
                          <a class="inline-flex items-center w-full text-sm font-semibol duration-150  dark:hover:text-gray-200"
                              href="{{ url('/') }}">
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                              </svg>                              
                              <span class="ml-4">Home</span>
                          </a>
                      </li>
                      @if(in_array(Auth::User()->role_id, [1, 2, 3]))
                      <li class="relative px-6 py-1">
                        <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150  dark:hover:text-gray-200"
                            href="{{ url('departments/index') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                              </svg>
                            <span class="ml-4">Departments</span>
                        </a>
                    </li>
                    @endif
                   @if(Auth::User()->role_id !== 5)
                   <li class="relative px-6 py-1">
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150  dark:hover:text-gray-200"
                        href="{{ url('users/index') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                          </svg>                              

                        <span class="ml-4">Staff</span>
                    </a>
                </li>
                   @endif
                      <li class="relative px-6 py-1">
                          <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150  dark:hover:text-gray-200"
                              href="{{ url('leaverequests/dashboard') }}">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                <path d="M3.196 12.87l-.825.483a.75.75 0 000 1.294l7.25 4.25a.75.75 0 00.758 0l7.25-4.25a.75.75 0 000-1.294l-.825-.484-5.666 3.322a2.25 2.25 0 01-2.276 0L3.196 12.87z" />
                                <path d="M3.196 8.87l-.825.483a.75.75 0 000 1.294l7.25 4.25a.75.75 0 00.758 0l7.25-4.25a.75.75 0 000-1.294l-.825-.484-5.666 3.322a2.25 2.25 0 01-2.276 0L3.196 8.87z" />
                                <path d="M10.38 1.103a.75.75 0 00-.76 0l-7.25 4.25a.75.75 0 000 1.294l7.25 4.25a.75.75 0 00.76 0l7.25-4.25a.75.75 0 000-1.294l-7.25-4.25z" />
                              </svg>

                              <span class="ml-4">Leave Request</span>
                          </a>
                      </li>

         
                      <li class="relative px-6 py-1">
                          <button
                              class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150  dark:hover:text-gray-200"
                              @click="togglePagesMenu" aria-haspopup="true">
                              <span class="inline-flex items-center">
                                  <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                                      stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                      stroke="currentColor">
                                      <path
                                          d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z">
                                      </path>
                                  </svg>
                                  <span class="ml-4">Settings</span>
                              </span>
                              <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                  <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                      clip-rule="evenodd"> </path>
                              </svg>
                          </button>
                          <template x-if="isPagesMenuOpen">
                              <ul x-transition:enter="transition-all ease-in-out duration-300"
                                  x-transition:enter-start="opacity-25 max-h-0"
                                  x-transition:enter-end="opacity-100 max-h-xl"
                                  x-transition:leave="transition-all ease-in-out duration-300"
                                  x-transition:leave-start="opacity-100 max-h-xl"
                                  x-transition:leave-end="opacity-0 max-h-0"
                                  class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
                                  aria-label="submenu">
                                  <li
                                      class="px-2 py-2 transition-colors duration-150  dark:hover:text-gray-200">
                                      <a class="w-full" href="{{ url('academic') }}">Academics</a>
                                  </li>
                                  <li
                                      class="px-2 py-2 transition-colors duration-150  dark:hover:text-gray-200">
                                      <a class="w-full" href="{{ url('accounting') }}">
                                          Accounting
                                      </a>
                                  </li>
                                  <li
                                      class="px-2 py-2 transition-colors duration-150  dark:hover:text-gray-200">
                                      <a class="w-full" href="{{ url('permission') }}">
                                          Permissions
                                      </a>
                                  </li>
                                  <li
                                      class="px-2 py-2 transition-colors duration-150  dark:hover:text-gray-200">
                                      <a class="w-full" href="{{ url('system') }}">System Setting</a>
                                  </li>
                              </ul>
                          </template>
                      </li>
              </ul>
          </div>
      </aside>
      <div class="flex flex-col flex-1 w-full">
        <header id="topnavheader" class="z-10 py-4 bg-white shadow-md dark:bg-gray-800">
          <div class="container flex items-center justify-between h-full px-6 mx-auto text-genedark dark:text-blue-300">
              <!-- Mobile hamburger -->
              <button class="p-1 -ml-1 mr-5 rounded-md md:hidden focus:outline-none focus:shadow-outline-purple"
                  @click="toggleSideMenu" aria-label="Menu">
                  <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd"
                          d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                          clip-rule="evenodd"></path>
                  </svg>
              </button>
              <!-- Search input -->
              <div class="flex flex-1 lg:mr-32">
                  <div class="relative w-full max-w-xl mr-6 focus-within:text-genedark">
                      <div class="absolute inset-y-0 flex items-center pl-2">
                          <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                              <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                  clip-rule="evenodd"></path>
                          </svg>
                      </div>
                      <input
                          class="w-full pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-blue-300 focus:outline-none focus:shadow-outline-purple form-input"
                          type="text" id="search_here" placeholder="Search Student, Parent or Staff Here"
                          aria-label="Search" />
                  </div>
              </div>
              <ul class="flex items-center flex-shrink-0 space-x-6">
                  <!-- Notifications menu --> 
                  <li class="relative">
                      <button
                          class=" px-4 py-2 w-full text-sm text-white shadow-sm bg-genered focus:ring outline-none flex justify-between gap-x-2 items-center rounded-md focus:outline-none focus:shadow-outline-purple"
                          @click="toggleNotificationsMenu" @keydown.escape="closeNotificationsMenu"
                          aria-label="Notifications" aria-haspopup="true">
                          <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                              <path
                                  d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z">
                              </path>
                          </svg> 10
                          <!-- Notification badge -->
                          <span aria-hidden="true" class="absolute top-0 right-0 inline-block w-3 h-3 transform translate-x-1 -translate-y-1 bg-red-600 border-2 border-white rounded-full dark:border-gray-800">
                          </span>
                      </button>
                      <template x-if="isNotificationsMenuOpen">
                          <ul x-transition:leave="transition ease-in duration-150"
                              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                              @click.away="closeNotificationsMenu" @keydown.escape="closeNotificationsMenu"
                              class="absolute right-0 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:text-gray-300 dark:border-gray-700 dark:bg-gray-700"
                              aria-label="submenu">
                              <li class="flex">
                                  <a class="inline-flex items-center justify-between w-full px-2 py-2 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100  dark:hover:bg-gray-800 dark:hover:text-gray-200"
                                      href="#">
                                      <span>Messages</span>
                                      <span class="inline-flex items-center justify-center px-2 py-2 text-xs font-bold leading-none text-red-600 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-600">
                                          13
                                      </span>
                                  </a>
                              </li>
                              <li class="flex">
                                  <a class="inline-flex items-center justify-between w-full px-2 py-2 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100  dark:hover:bg-gray-800 dark:hover:text-gray-200"
                                      href="/birthday">
                                      <span>Today Birthdays</span>
                                      <span
                                          class="inline-flex items-center justify-center px-2 py-2 text-xs font-bold leading-none text-red-600 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-600">
                                          2
                                      </span>
                                  </a>
                              </li>
                              <li class="flex">
                                  <a class="inline-flex items-center justify-between w-full px-2 py-2 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100  dark:hover:bg-gray-800 dark:hover:text-gray-200"
                                      href="#">
                                      <span>Alerts</span>
                                      <span class="inline-flex items-center justify-center px-2 py-2 text-xs font-bold leading-none text-red-600 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-600">
                                        22
                                    </span>
                                  </a>
                              </li>
                          </ul>
                      </template>
                  </li>
                  <!-- Profile menu -->
                  <li class="relative">
                      <button class="align-middle rounded-full focus:shadow-outline-purple focus:outline-none"
                          @click="toggleProfileMenu" @keydown.escape="closeProfileMenu" aria-label="Account"
                          aria-haspopup="true">
                          <img class="object-cover w-8 h-8 rounded-full"
                              src="{{ Auth::User() && Auth::User()->profile_photo_url != '' ? Auth::User()->profile_photo_url : '/profile.svg' }}"
                              alt="Genesis School" aria-hidden="true" />
                      </button>
                      <template x-if="isProfileMenuOpen">
                          <ul x-transition:leave="transition ease-in duration-150"
                              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                              @click.away="closeProfileMenu" @keydown.escape="closeProfileMenu"
                              class="absolute right-0 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:border-gray-700 dark:text-gray-300 dark:bg-gray-700"
                              aria-label="submenu">
                              <li class="flex">
                                  <a class="inline-flex items-center w-full px-2 py-2 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100  dark:hover:bg-gray-800 dark:hover:text-gray-200"
                                      href="#">
                                      <svg class="w-4 h-4 mr-3" aria-hidden="true" fill="none"
                                          stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          viewBox="0 0 24 24" stroke="currentColor">
                                          <path
                                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                          </path>
                                      </svg>
                                      <span>{{ Auth::User() ? Auth::User()->name : '' }}
                                      </span>
                                  </a>
                              </li>
                                  <li class="flex">
                                      <a class="inline-flex items-center w-full px-2 py-2 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100  dark:hover:bg-gray-800 dark:hover:text-gray-200"
                                          href="#">
                                          <svg class="w-4 h-4 mr-3" aria-hidden="true" fill="none"
                                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              viewBox="0 0 24 24" stroke="currentColor">
                                              <path
                                                  d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                              </path>
                                              <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                          </svg>
                                          <span>Settings</span>
                                      </a>
                                  </li>
                            <!-- Theme toggler -->
                              <li class="flex">
                                <button class="inline-flex items-center w-full px-2 py-2 text-sm font-semibold transition-colors duration-150 hover:bg-gray-100  dark:hover:bg-gray-800 dark:hover:text-gray-200 rounded-md focus:outline-none focus:shadow-outline-purple"
                                    @click="toggleTheme" aria-label="Toggle color mode">
                                    <template x-if="!dark">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z">
                                            </path>
                                        </svg> 
                                    </template>
                                    <template x-if="dark">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </template>
                                    Light/Dark Mode
                                </button>
                            </li>
                            <li class="flex">
                                <a class="inline-flex items-center w-full px-2 py-2 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100  hover:text-purple-500 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                                    href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                    <svg class="w-4 h-4 mr-3" aria-hidden="true" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path
                                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                    <span>Log out</span>
                                </a>
                            </li>
                              <li class="flex">
                                  {{-- <a class="inline-flex items-center w-full px-2 py-2 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100  dark:hover:bg-gray-800 dark:hover:text-gray-200"
                                      href="{{ route('logout') }}"
                                      onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                      <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                          {{ csrf_field() }}
                                      </form>
                                      <svg class="w-4 h-4 mr-3" aria-hidden="true" fill="none"
                                          stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          viewBox="0 0 24 24" stroke="currentColor">
                                          <path
                                              d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                          </path>
                                      </svg>
                                      <span>Log out</span>
                                  </a> --}}
                              </li>
                          </ul>
                      </template>
                  </li>
              </ul>
          </div>
        </header>
        <main class="h-full overflow-y-auto">
          <div class="container px-6 mb-6 mx-auto grid">
              <div id="search_result" style="display: none;"
                  class="min-w-0 mt-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                  {{-- Search data goes here --}}
              </div>
              @inertia
          </div>
        </main>
      </div>
  </div>

    <script>
        results = function() {
            $('#search_here').keyup(function() {
                var q = $(this).val();
                $.ajax({
                    type: 'POST',
                    url: "<?= url('/searchs') ?>",
                    data: "q=" + q,
                    dataType: "html",
                    success: function(data) {
                        $('#search_result').html(data).show();
                    }
                });
            });
        }
        $(document).ready(results);


        $(document).ready(function() {
            $('form').on('submit', function(e) {
                // validation code here
                e.preventDefault();
            });
        });

        $(document).ready(function() {
            $('.select-single').select2();
            $('.select-multiple').select2();

            $('#class_id').change(function(event) {
                var class_id = $(this).val();
                if (class_id === '0') {
                    $('#class_id').val(0);
                } else {
                    $.ajax({
                        type: 'POST',
                        url: "<?= url('classes/sectioncall') ?>",
                        data: {
                            "id": class_id,
                            all_section: 1
                        },
                        dataType: "html",
                        success: function(data) {
                            $('#section_id').html(data);
                        }
                    });
                }
            });


            $('#class_id').change(function(event) {
                var class_id = $(this).val();
                if (class_id === '0') {
                    $('#class_id').val(0);
                } else {
                    $.ajax({
                        type: 'POST',
                        url: "<?= url('classes/call_academicyear') ?>",
                        data: "class_id=" + class_id,
                        dataType: "html",
                        success: function(data) {
                            $('#academicyear_id').html(data);
                        }
                    });
                }
            });
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            @if (session()->has('success'))
                toastr.success("{{ session()->get('success') }}");
            @endif

            @if (session()->has('error'))
                toastr.error("{{ session()->get('error') }}");
            @endif

            @if (session()->has('info'))
                toastr.info("{{ session()->get('info') }}");
            @endif

            @if (session()->has('warning'))
                toastr.warning("{{ session()->get('warning') }}");
            @endif

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>
</body>

</html>
