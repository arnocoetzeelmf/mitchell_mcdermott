<!DOCTPE html>
<html>
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <title>My Blogs</title>
    </head>
    <body>
        <div class="row pt-3">
            <div class="col-4 pl-5">
                <a class="btn btn-small btn-info" href="blog_view">View All Blogs</a>
            </div>
            <div class="col-4 display-4 text-center">
                <u>My Blogs</u>
            </div>
            <div class="col-4 text-right pr-5">
                @auth
                    <a class="btn btn-small btn-info" href="javascript:void(0)" id="createNewBlog">Add Blog Entry</a>
                    <a class="btn btn-small btn-info" href="{{ url('/logout') }}" onclick="if(!confirm('Are you sure you want to logout?')){event.preventDefault();}"> Logout </a>
                @endauth
            </div>
        </div>

        <div class="p-5">
            <table class="p-4 table">
                <thead>
                    <tr>
                        <th width="20%">Title</th>
                        <th width="60%">Blog</th>
                        <th width="20%"><a id="publication_datetime_order" href="">Publication Date/Time</a></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($blogs as $blog)
                    <tr>
                        <td>{{ $blog->blog_title }}</td>
                        <td>{!! nl2br($blog->blog_text) !!}</td>
                        <td>{{ $blog->publication_datetime }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="modal fade" id="blogModel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modelHeading"></h4>
                    </div>
                    <div class="modal-body">
                        <form id="productForm" name="productForm" class="form-horizontal">
                        <input type="hidden" name="product_id" id="product_id">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Title</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="blog_title" name="blog_title" placeholder="Enter Title Here" value="" maxlength="200" required>
                                </div>
                                <label for="name" class="pt-3 col-sm-2 control-label">Details</label>
                                <div class="col-sm-12">
                                    <textarea rows="18" id="blog_text" name="blog_text" required placeholder="Enter Blog Details Here" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="row">
                            <div class="pl-4 col-6 text-left">
                                    <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes</button>
                                </div>
                                <div class="pr-4 col-6 text-right">
                                    <button type="submit" class="btn btn-primary" id="cancelBtn" value="create">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script type="text/javascript">
        jQuery(function () {
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            
            jQuery('#createNewBlog').click(function () {
                jQuery('#saveBtn').val("create-blog");
                jQuery('#blog_title').val('');
                jQuery('#blog_text').val('');
                jQuery('#modelHeading').html("Create New Blog");
                jQuery('#blogModel').modal('show');
            });
            
            jQuery('#saveBtn').click(function (e) {
                e.preventDefault();

                if(!confirm('Are you sure you want to save the blog entry?')){
                    return;
                }

                var blog_object = {
                    blog_title:jQuery('#blog_title').val(),
                    blog_text:jQuery('#blog_text').val(),
                };

                jQuery.ajax({
                    type: "POST",
                    url: "my_blog_view/store",
                    data: blog_object,
                }).done(function (response) {
                    location.reload();
                    jQuery('#blogModel').modal('hide');
                }).fail(function (e) {
                    if(e.status == 422){
                        let errors_object = JSON.parse(e.responseText);
                        alert(errors_object.message);
                    }else{
                        alert(e.statusText);
                    }
                });
            });

            jQuery('#cancelBtn').click(function (e) {
                e.preventDefault();
                if(confirm('Are you sure you want to cancel?\nAll changes you made will be lost.')){
                    jQuery('#blogModel').modal('hide');
                }
            });

            jQuery('#publication_datetime_order').click(function (e) {
                e.preventDefault();
                console.log('ordering');

                var searchParams = new URLSearchParams(window.location.search);
                if(searchParams.has('order')){
                    let param = searchParams.get('order');
                    console.log(param);
                    window.location = 'my_blog_view?order='+(param == 'desc' ? 'asc' : 'desc');
                }else{
                    window.location = 'my_blog_view?order=asc';
                }
            });
        });
    </script>
</html>