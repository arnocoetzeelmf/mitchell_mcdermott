<!DOCTPE html>
<html>
    <head>
        <title>Blogs</title>
    </head>
    <body>
        <table border="1">
            <tr>
                <td>First Name</td>
                <td>Last Name</td>
                <td>City Name</td>
            </tr>
            @foreach ($blogs as $blog)
            <tr>
                <td>{{ $blog->blog_title }}</td>
                <td>{{ $blog->blog_text }}</td>
                <td>{{ $blog->publication_datetime }}</td>
            </tr>
            @endforeach
        </table>
    </body>
</html>