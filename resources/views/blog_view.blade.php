<!DOCTPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
        <title>All Blogs</title>
    </head>
    <body>
        <div class="row pt-3">
            <div class="col-4 pl-5">
                @auth
                    <a class="btn btn-small btn-info" href="my_blog_view">View My Blogs</a>
                @endauth
            </div>
            <div class="col-4 display-4 text-center">
                <u>All Blogs</u>
            </div>
            <div class="col-4 text-right pr-5">
                @auth
                    <a class="btn btn-small btn-info" href="{{ url('/logout') }}" onclick="if(!confirm('Are you sure you want to logout?')){event.preventDefault();}">Logout</a>
                @else
                    <a class="btn btn-small btn-info" href="login">Login</a>
                @endauth
            </div>
        </div>

        <div class="p-5">
            <table class="p-4 table">
                <thead>
                    <tr>
                        <th width="20%">Title</th>
                        <th width="60%">Blog</th>
                        <th width="10%">Publication Date/Time</th>
                        <th width="10%">Created By</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($blogs as $blog)
                    <tr>
                        <td>{{ $blog->blog_title }}</td>
                        <td>{{ $blog->blog_text }}</td>
                        <td>{{ $blog->publication_datetime }}</td>
                        <td>{{ $blog->name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </body>
</html>