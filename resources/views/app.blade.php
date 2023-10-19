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
                  <img aria-hidden="true" class="h-full ml-6 dark:hidden" src="/genesis-logo.png" alt="Genesis School"
                      width="60%" />
              </a>
              <ul class="mt-4 text-gray-100">

                      <li class="relative px-6 py-1">
                          @if($thispage == 'home' ||$thispage == 'dashboard' || $thispage == '')
                           <?=$current_page?>
                          @endif
                          <a class="inline-flex items-center w-full text-sm font-semibol duration-150  dark:hover:text-gray-200"
                              href="{{ url('/') }}">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                <path fill-rule="evenodd" d="M9.293 2.293a1 1 0 011.414 0l7 7A1 1 0 0117 11h-1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-3a1 1 0 00-1-1H9a1 1 0 00-1 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6H3a1 1 0 01-.707-1.707l7-7z" clip-rule="evenodd" />
                              </svg>
                              <span class="ml-4">Home</span>
                          </a>
                      </li>
                      <li class="relative px-6 py-1">
                        @if($thispage == 'sections' ||$thispage == 'classes')
                           <?=$current_page?>
                          @endif
                          <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150  dark:hover:text-gray-200"
                              href="{{ url('classes') }}">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                <path fill-rule="evenodd" d="M4.25 2A2.25 2.25 0 002 4.25v2.5A2.25 2.25 0 004.25 9h2.5A2.25 2.25 0 009 6.75v-2.5A2.25 2.25 0 006.75 2h-2.5zm0 9A2.25 2.25 0 002 13.25v2.5A2.25 2.25 0 004.25 18h2.5A2.25 2.25 0 009 15.75v-2.5A2.25 2.25 0 006.75 11h-2.5zm9-9A2.25 2.25 0 0011 4.25v2.5A2.25 2.25 0 0013.25 9h2.5A2.25 2.25 0 0018 6.75v-2.5A2.25 2.25 0 0015.75 2h-2.5zm0 9A2.25 2.25 0 0011 13.25v2.5A2.25 2.25 0 0013.25 18h2.5A2.25 2.25 0 0018 15.75v-2.5A2.25 2.25 0 0015.75 11h-2.5z" clip-rule="evenodd" />
                              </svg>                              
                              <span class="ml-4">Classes</span>
                          </a>
                      </li>

                      <li class="relative px-6 py-1">
                        @if($thispage == 'subjects' || $thispage == 'subject' || $thispage == 'view-subjects')
                           <?=$current_page?>
                          @endif
                          <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150  dark:hover:text-gray-200"
                              href="{{ url('subjects') }}">
                              <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"  stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>                          
                              <span class="ml-4">Subjects</span>
                          </a>
                      </li>

                      <li class="relative px-6 py-1">
                        @if($thispage == 'lessonplan' || $thispage == 'createlessonshedule' || $thispage == 'lessonplans')
                           <?=$current_page?>
                          @endif
                          <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150  dark:hover:text-gray-200"
                              href="{{ url('/lessonplans/dashboard/') }}">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                <path d="M4.464 3.162A2 2 0 016.28 2h7.44a2 2 0 011.816 1.162l1.154 2.5c.067.145.115.291.145.438A3.508 3.508 0 0016 6H4c-.288 0-.568.035-.835.1.03-.147.078-.293.145-.438l1.154-2.5z" />
                                <path fill-rule="evenodd" d="M2 9.5a2 2 0 012-2h12a2 2 0 110 4H4a2 2 0 01-2-2zm13.24 0a.75.75 0 01.75-.75H16a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75h-.01a.75.75 0 01-.75-.75V9.5zm-2.25-.75a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75H13a.75.75 0 00.75-.75V9.5a.75.75 0 00-.75-.75h-.01zM2 15a2 2 0 012-2h12a2 2 0 110 4H4a2 2 0 01-2-2zm13.24 0a.75.75 0 01.75-.75H16a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75h-.01a.75.75 0 01-.75-.75V15zm-2.25-.75a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75H13a.75.75 0 00.75-.75V15a.75.75 0 00-.75-.75h-.01z" clip-rule="evenodd" />
                              </svg>                              
                              <span class="ml-4">Lesson Plan</span>
                          </a>
                      </li>

                      <li class="relative px-6 py-1">
                        @if($thispage == 'attendance' ||$thispage == 'attendances')
                           <?=$current_page?>
                          @endif
                          <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150  dark:hover:text-gray-200"
                              href="{{ url('attendances') }}">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                <path fill-rule="evenodd" d="M11 2a1 1 0 10-2 0v6.5a.5.5 0 01-1 0V3a1 1 0 10-2 0v5.5a.5.5 0 01-1 0V5a1 1 0 10-2 0v7a7 7 0 1014 0V8a1 1 0 10-2 0v3.5a.5.5 0 01-1 0V3a1 1 0 10-2 0v5.5a.5.5 0 01-1 0V2z" clip-rule="evenodd" />
                              </svg>
                              <span class="ml-4">Attendances</span>
                          </a>
                      </li>
 
                      <li class="relative px-6 py-1">
                        @if($thispage == 'users' || $thispage == 'viewuser')
                           <?=$current_page?>
                          @endif
                          <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150  dark:hover:text-gray-200"
                              href="{{ url('users') }}">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                <path d="M10 9a3 3 0 100-6 3 3 0 000 6zM6 8a2 2 0 11-4 0 2 2 0 014 0zM1.49 15.326a.78.78 0 01-.358-.442 3 3 0 014.308-3.516 6.484 6.484 0 00-1.905 3.959c-.023.222-.014.442.025.654a4.97 4.97 0 01-2.07-.655zM16.44 15.98a4.97 4.97 0 002.07-.654.78.78 0 00.357-.442 3 3 0 00-4.308-3.517 6.484 6.484 0 011.907 3.96 2.32 2.32 0 01-.026.654zM18 8a2 2 0 11-4 0 2 2 0 014 0zM5.304 16.19a.844.844 0 01-.277-.71 5 5 0 019.947 0 .843.843 0 01-.277.71A6.975 6.975 0 0110 18a6.974 6.974 0 01-4.696-1.81z" />
                              </svg>
                                                           
                              <span class="ml-4">Staffs</span>
                          </a>
                      </li>
  
                      <li class="relative px-6 py-1">
                        @if($thispage == 'homework' || $thispage == 'homeworks')
                           <?=$current_page?>
                          @endif
                          <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150  dark:hover:text-gray-200"
                              href="{{ url('homework') }}">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                <path d="M4.75 3A1.75 1.75 0 003 4.75v2.752l.104-.002h13.792c.035 0 .07 0 .104.002V6.75A1.75 1.75 0 0015.25 5h-3.836a.25.25 0 01-.177-.073L9.823 3.513A1.75 1.75 0 008.586 3H4.75zM3.104 9a1.75 1.75 0 00-1.673 2.265l1.385 4.5A1.75 1.75 0 004.488 17h11.023a1.75 1.75 0 001.673-1.235l1.384-4.5A1.75 1.75 0 0016.896 9H3.104z" />
                              </svg>
                              <span class="ml-4">Homeworks</span>
                          </a>
                      </li>
     
                      <li class="relative px-6 py-1">
                        @if($thispage == 'exam' || $thispage == 'exams')
                           <?=$current_page?>
                          @endif
                          <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150  dark:hover:text-gray-200"
                              href="{{ url('exams') }}">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                <path fill-rule="evenodd" d="M5 2.75C5 1.784 5.784 1 6.75 1h6.5c.966 0 1.75.784 1.75 1.75v3.552c.377.046.752.097 1.126.153A2.212 2.212 0 0118 8.653v4.097A2.25 2.25 0 0115.75 15h-.241l.305 1.984A1.75 1.75 0 0114.084 19H5.915a1.75 1.75 0 01-1.73-2.016L4.492 15H4.25A2.25 2.25 0 012 12.75V8.653c0-1.082.775-2.034 1.874-2.198.374-.056.75-.107 1.127-.153L5 6.25v-3.5zm8.5 3.397a41.533 41.533 0 00-7 0V2.75a.25.25 0 01.25-.25h6.5a.25.25 0 01.25.25v3.397zM6.608 12.5a.25.25 0 00-.247.212l-.693 4.5a.25.25 0 00.247.288h8.17a.25.25 0 00.246-.288l-.692-4.5a.25.25 0 00-.247-.212H6.608z" clip-rule="evenodd" />
                              </svg>                              
                              <span class="ml-4">Exam Report</span>
                          </a>
                      </li>
 
                      <li class="relative px-6 py-1">
                          <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150  dark:hover:text-gray-200"
                              href="{{ url('transactions') }}">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                <path d="M10.75 10.818v2.614A3.13 3.13 0 0011.888 13c.482-.315.612-.648.612-.875 0-.227-.13-.56-.612-.875a3.13 3.13 0 00-1.138-.432zM8.33 8.62c.053.055.115.11.184.164.208.16.46.284.736.363V6.603a2.45 2.45 0 00-.35.13c-.14.065-.27.143-.386.233-.377.292-.514.627-.514.909 0 .184.058.39.202.592.037.051.08.102.128.152z" />
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-6a.75.75 0 01.75.75v.316a3.78 3.78 0 011.653.713c.426.33.744.74.925 1.2a.75.75 0 01-1.395.55 1.35 1.35 0 00-.447-.563 2.187 2.187 0 00-.736-.363V9.3c.698.093 1.383.32 1.959.696.787.514 1.29 1.27 1.29 2.13 0 .86-.504 1.616-1.29 2.13-.576.377-1.261.603-1.96.696v.299a.75.75 0 11-1.5 0v-.3c-.697-.092-1.382-.318-1.958-.695-.482-.315-.857-.717-1.078-1.188a.75.75 0 111.359-.636c.08.173.245.376.54.569.313.205.706.353 1.138.432v-2.748a3.782 3.782 0 01-1.653-.713C6.9 9.433 6.5 8.681 6.5 7.875c0-.805.4-1.558 1.097-2.096a3.78 3.78 0 011.653-.713V4.75A.75.75 0 0110 4z" clip-rule="evenodd" />
                              </svg>                                                           
                              <span class="ml-4">School Fees</span>
                          </a>
                      </li>
     
                      <li class="relative px-6 py-1">
                          <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150  dark:hover:text-gray-200"
                              href="{{ url('books/index') }}">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                <path fill-rule="evenodd" d="M15.988 3.012A2.25 2.25 0 0118 5.25v6.5A2.25 2.25 0 0115.75 14H13.5V7A2.5 2.5 0 0011 4.5H8.128a2.252 2.252 0 011.884-1.488A2.25 2.25 0 0112.25 1h1.5a2.25 2.25 0 012.238 2.012zM11.5 3.25a.75.75 0 01.75-.75h1.5a.75.75 0 01.75.75v.25h-3v-.25z" clip-rule="evenodd" />
                                <path fill-rule="evenodd" d="M2 7a1 1 0 011-1h8a1 1 0 011 1v10a1 1 0 01-1 1H3a1 1 0 01-1-1V7zm2 3.25a.75.75 0 01.75-.75h4.5a.75.75 0 010 1.5h-4.5a.75.75 0 01-.75-.75zm0 3.5a.75.75 0 01.75-.75h4.5a.75.75 0 010 1.5h-4.5a.75.75 0 01-.75-.75z" clip-rule="evenodd" />
                              </svg>                              
                              <span class="ml-4">E-Library</span>
                          </a>
                      </li>
   
                      <li class="relative px-6 py-1">
                          <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150  dark:hover:text-gray-200"
                              href="{{ url('stores') }}">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                <path d="M3.196 12.87l-.825.483a.75.75 0 000 1.294l7.25 4.25a.75.75 0 00.758 0l7.25-4.25a.75.75 0 000-1.294l-.825-.484-5.666 3.322a2.25 2.25 0 01-2.276 0L3.196 12.87z" />
                                <path d="M3.196 8.87l-.825.483a.75.75 0 000 1.294l7.25 4.25a.75.75 0 00.758 0l7.25-4.25a.75.75 0 000-1.294l-.825-.484-5.666 3.322a2.25 2.25 0 01-2.276 0L3.196 8.87z" />
                                <path d="M10.38 1.103a.75.75 0 00-.76 0l-7.25 4.25a.75.75 0 000 1.294l7.25 4.25a.75.75 0 00.76 0l7.25-4.25a.75.75 0 000-1.294l-7.25-4.25z" />
                              </svg>

                              <span class="ml-4">Leave Request</span>
                          </a>
                      </li>
     
                      <li class="relative px-6 py-1">
                          <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150  dark:hover:text-gray-200"
                              href="{{ url('stores') }}">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                <path d="M4.464 3.162A2 2 0 016.28 2h7.44a2 2 0 011.816 1.162l1.154 2.5c.067.145.115.291.145.438A3.508 3.508 0 0016 6H4c-.288 0-.568.035-.835.1.03-.147.078-.293.145-.438l1.154-2.5z" />
                                <path fill-rule="evenodd" d="M2 9.5a2 2 0 012-2h12a2 2 0 110 4H4a2 2 0 01-2-2zm13.24 0a.75.75 0 01.75-.75H16a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75h-.01a.75.75 0 01-.75-.75V9.5zm-2.25-.75a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75H13a.75.75 0 00.75-.75V9.5a.75.75 0 00-.75-.75h-.01zM2 15a2 2 0 012-2h12a2 2 0 110 4H4a2 2 0 01-2-2zm13.24 0a.75.75 0 01.75-.75H16a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75h-.01a.75.75 0 01-.75-.75V15zm-2.25-.75a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75H13a.75.75 0 00.75-.75V15a.75.75 0 00-.75-.75h-.01z" clip-rule="evenodd" />
                              </svg>                              
                              <span class="ml-4">Lesson Plan</span>
                          </a>
                      <
                      <li class="relative px-6 py-1">
                          <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150  dark:hover:text-gray-200"
                              href="{{ url('eventlist') }}">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                <path fill-rule="evenodd" d="M5.75 2a.75.75 0 01.75.75V4h7V2.75a.75.75 0 011.5 0V4h.25A2.75 2.75 0 0118 6.75v8.5A2.75 2.75 0 0115.25 18H4.75A2.75 2.75 0 012 15.25v-8.5A2.75 2.75 0 014.75 4H5V2.75A.75.75 0 015.75 2zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75z" clip-rule="evenodd" />
                              </svg>
                              <span class="ml-4">Events & Updates</span>
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
              <div class="px-6 my-6">
                  <button
                      class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-600 focus:outline-none focus:shadow-outline-purple">
                      Create account
                      <span class="ml-2" aria-hidden="true">+</span>
                  </button>
              </div>
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
                                      <span>Profile
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
