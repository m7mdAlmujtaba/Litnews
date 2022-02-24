@extends('layouts.dashboard.app')
@section('content')
<!-- Header -->
<div class="relative bg-pink-600 md:pt-32 pb-32 pt-12">
    <div class="px-4 md:px-10 mx-auto w-full">
        <div>
            <!-- Card stats -->
            <div class="flex flex-wrap">

                @if($errors->any())
                <div class="w-full px-4">
                    <div class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg">
                        <div class="flex-auto p-4">
                            <div class="flex flex-wrap">
                                <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                    <p><strong>Opps Something went wrong</strong></p>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if(session()->has('message'))
                <div class="w-full px-4">
                    <div class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg">
                        <div class="flex-auto p-4">
                            <div class="flex flex-wrap">
                                <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                    {{ session()->get('message') }}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
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
                                New Category
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="block w-full overflow-x-auto">
                    <!-- Projects table -->
                    <form role="form" method="POST" action="{{ route('dashboard.category.update', $category->id) }}" enctype="multipart/form-data">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="flex flex-wrap">
                            <div class="w-full lg:w-6/12 px-4">
                                <div class="relative w-full mb-3">
                                    <label class="block text-blueGray-600 font-bold mb-2" htmlFor="grid-password">
                                        Category name
                                    </label>
                                    <input type="text" name="name" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600
                                                 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" value="{{$category->name}}" />
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class=" text-center">
                            <button type="submit" class="py-2 px-3 mb-3 text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    @include('includes/dashboard/footer')
</div>

@endsection