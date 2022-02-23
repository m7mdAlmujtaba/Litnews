
@extends('layouts.dashboard.app')

@section('content')
            <!-- Header -->
            <div class="relative bg-pink-600 md:pt-32 pb-32 pt-12">
                <div class="px-4 md:px-10 mx-auto w-full">
                    <div>
                        <!-- Card stats -->
                        <div class="flex flex-wrap">
                            <div class="w-full lg:w-6/12 xl:w-3/12 px-4">
                                <a href="{{ route('dashboard.post.create')}}" class="py-2 px-3 mb-3 text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Add New Post</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-4 md:px-10 mx-auto w-full -m-24">
                <div class="flex flex-wrap mt-4">
                    <div class="w-full mb-12 px-4">
                        <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white">
                            <div class="rounded-t mb-0 px-4 py-3 border-0">
                                <div class="flex flex-wrap items-center">
                                    <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                                        <h3 class="font-semibold text-lg text-blueGray-700">
                                            Posts Table
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="block w-full overflow-x-auto">
                                <!-- Projects table -->
                                <table class="items-center w-full bg-transparent border-collapse">
                                    <thead>
                                        <tr>
                                            <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                                No
                                            </th>
                                            <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                                Title
                                            </th>
                                            <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                                Author
                                            </th>
                                            <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                                Date
                                            </th>
                                            <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                                Category
                                            </th>
                                            <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                                Status
                                            </th>
                                            <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($posts as $post)
                                        <tr>
                                            <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left flex items-center">
                                                {{$loop->index + 1}}
                                            </th>
                                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                {{$post->title}}
                                            </td>
                                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                {{$post->user->name}}
                                            </td>
                                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                {{$post->created_at}}
                                            </td>
                                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                Category Name
                                            </td>
                                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                @if($post->status == 0)
                                                <i class="fas fa-circle text-orange-500 mr-2"></i>
                                                Draft
                                                @else
                                                <i class="fas fa-circle text-indigo-600 mr-2"></i>
                                                Published
                                                @endif
                                            </td>

                                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                            </td>
                                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-right">
                                                <a href="#" class="text-blueGray-500 block py-1 px-3" onclick="openDropdown(event,'table-light-1-dropdown')">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="hidden bg-white text-base z-50 float-left py-2 list-none text-left rounded shadow-lg min-w-48" id="table-light-1-dropdown">
                                                    <a href="#pablo" class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700">Edit</a>
                                                    <a href="#pablo" class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700">Trash</a>
                                                    <div class="h-0 my-2 border border-solid border-blueGray-100"></div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                @include('includes/dashboard/footer')
            </div>
@endsection