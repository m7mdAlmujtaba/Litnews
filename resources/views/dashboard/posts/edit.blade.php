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
                                New Post
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="block w-full overflow-x-auto">
                    <!-- Projects table -->
                    <form role="form" method="POST" action="{{ route('dashboard.post.update', $post->id) }}" enctype="multipart/form-data">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="flex flex-wrap">
                            <div class="w-full lg:w-6/12 px-4">
                                <div class="relative w-full mb-3">
                                    <label class="block text-blueGray-600 font-bold mb-2" htmlFor="grid-password">
                                        Post Title
                                    </label>
                                    <input type="text" name="title" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600
                                                 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" placeholder="Post Title" value="{{$post->title}}" />
                                </div>
                            </div>

                            <div class="w-full lg:w-6/12 px-4">
                                <div class="relative w-full mb-3">
                                    <label class="block text-blueGray-600 font-bold mb-2" htmlFor="post_image">
                                        Post Image
                                    </label>
                                    <input name="image" class="border-0 px-3 py-3 text-blueGray-600 bg-white 
                                                rounded shadow focus:outline-none focus:ring w-full
                                                ease-linear transition-all duration-150
                                               " aria-describedby="user_avatar_help" id="post_image" type="file">
                                </div>
                            </div>

                            <div class="w-full lg:w-8/12 px-4">
                                <div class="relative w-full mb-3">
                                    <label class="block text-blueGray-600 font-bold mb-2" htmlFor="grid-password">
                                        Post Content
                                    </label>
                                    <textarea type="textarea" name="body" class="border-0 px-3 py-3 text-blueGray-600
                                                 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">{{$post->body}} </textarea>
                                </div>
                            </div>
                            <div class="w-full lg:w-4/12 px-4">
                            <label class="block text-blueGray-600 font-bold mb-2" htmlFor="grid-password">
                                        Category
                                    </label>
                                <select id="categories" name="category" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600
                                                 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all">
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}" class="px-3 py-3" {{$category->id == $post->category_id? "selected":""}} >{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="px-4">
                                <div class="form-check">
                                    <input type="checkbox" name="status" class="form-check-input mr-2" id="statuscheck">
                                    <label class="form-check-label" for="exampleCheck1">Publish</label>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class=" text-center">
                            <button type="submit" class="py-2 px-3 mb-3 text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    @include('includes/dashboard/footer')
</div>

@endsection