<!DOCTYPE html>
<html>
<head>
    <title>Laravel Ajax CRUD Tutorial Example - ItSolutionStuff.com</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css"/>
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
</head>
<body>

<div class="container">
    <h1>Laravel CRUD</h1>
    <a class="btn btn-success" href="javascript:void(0)" id="createNewProduct"> Create New Account</a>
    <div id="msg"></div>
    <button class="btn btn-danger" id="delete_selected">Delete Selected Account(s)</button>
{{--    <button class="btn btn-warning" id="export">Export Selected Account(s)</button>--}}
    <table class="table table-bordered data-table">
        <thead>
        <tr>
            <th>Select All<input  type="checkbox" id="cq"/></th>
            <th>ID</th>
            <th>Username</th>
            <th>Name</th>
            <th>sex</th>
            <th>Birthday</th>
            <th>Email</th>
            <th>Remark</th>
            <th width="280px">Action</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form id="productForm" name="productForm" class="form-horizontal needs-validation" novalidate>
                    <input type="hidden" name="product_id" id="product_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Username</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="username" name="username"
                                   placeholder="Enter Username" value="" maxlength="50" required>
                            <div class="invalid-feedback">
                                Please enter a valid email address
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name"
                                   value="" maxlength="50" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Sex</label>
                        <select class="form-select" aria-label="Default select example" id="sex" name="sex" required>
                            <option selected>Open this select menu</option>
                            <option value="0">女</option>
                            <option value="1">男</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Birthday</label>
                        <div class="md-form md-outline input-with-post-icon datepicker">
                            <input placeholder="Select date" type="date" id="birthday" name="birthday" class="form-control" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-12">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email"
                                   value="" maxlength="50" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Remark</label>
                        <div class="col-sm-12">
                            <textarea id="remark" name="remark" required="" placeholder="Enter Details"
                                      class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>

<script type="text/javascript">
    $(function () {

        /*------------------------------------------
         --------------------------------------------
         Pass Header Token
         --------------------------------------------
         --------------------------------------------*/
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        /*------------------------------------------
        --------------------------------------------
        Render DataTable
        --------------------------------------------
        --------------------------------------------*/
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('account-infos.index') }}",
            columns: [
                {render : function(data, type, row, meta) {
                        var content = '<label   style="margin-left:32px;"  class="mt-checkbox mt-checkbox-single mt-checkbox-outline">';
                        content += '    <input type="checkbox"  name="test"  class="cq"" value="'
                            + row.id + '" />';
                        content += '</label>';
                        return content;
                    }},
                {data: 'id', name: 'id'},
                {data: 'username', name: 'username'},
                {data: 'name', name: 'name'},
                {data: 'sex', name: 'sex'},
                {data: 'birthday', name: 'birthday'},
                {data: 'email', name: 'email'},
                {data: 'remark', name: 'remark'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            columnDefs : [ {
                targets : 0,
                "orderable" : false
            } ]
        });

        /*------------------------------------------
        --------------------------------------------
        Click to Button
        --------------------------------------------
        --------------------------------------------*/
        $('#createNewProduct').click(function () {
            $('#saveBtn').val("create-product");
            $('#product_id').val('');
            $('#productForm').trigger("reset");
            $('#modelHeading').html("Create New Account");
            $('#ajaxModel').modal('show');
        });

        /*------------------------------------------
        --------------------------------------------
        Click to Edit Button
        --------------------------------------------
        --------------------------------------------*/
        $('body').on('click', '.editAccountInfo', function () {
            var product_id = $(this).data('id');
            $.get("{{ route('account-infos.index') }}" + '/' + product_id + '/edit', function (data) {
                $('#modelHeading').html("Edit Product");
                $('#saveBtn').val("edit-user");
                $('#ajaxModel').modal('show');
                $('#product_id').val(data.id);
                $('#username').val(data.username);
                $('#name').val(data.name);
                $('#sex').val(data.sex);
                $('#birthday').val(data.birthday);
                $('#email').val(data.email);
                $('#remark').val(data.remark);
            })
        });

        /*------------------------------------------
        --------------------------------------------
        Create Code
        --------------------------------------------
        --------------------------------------------*/
        $('#saveBtn').click(function (e) {
            e.preventDefault();

            var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
            var username = $('#username').val();
            var name = $('#name').val();
            var sex = parseInt($('#sex').val());
            var birthday = $('#birthday').val();
            var email = $('#email').val();
            console.log(Number.isInteger(sex));
            if(username.trim() == '' ){
                alert('Please enter your username.');
                $('#username').focus();
                return false;
            }else if(name.trim() == '' ){
                alert('Please enter your name.');
                $('#name').focus();
                return false;
            }else if(!Number.isInteger(sex)){
                alert('Please select your sex.');
                $('#sex').focus();
                return false;
            }else if(birthday.trim() == ''){
                alert('Please enter your birthday.');
                $('#birthday').focus();
                return false;
            }else if(email.trim() == '' ){
                alert('Please enter your email.');
                $('#email').focus();
                return false;
            }else if(email.trim() != '' && !reg.test(email)){
                alert('Please enter valid email.');
                $('#inputEmail').focus();
                return false;
            }else {
                $(this).html('Sending..');
                $.ajax({
                    data: $('#productForm').serialize(),
                    url: "{{ route('account-infos.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {

                        $('#productForm').trigger("reset");
                        $('#ajaxModel').modal('hide');
                        table.draw();

                    },
                    error: function (data) {
                        $('#saveBtn').html('Save');
                    }
                });
            }
        });

        /*------------------------------------------
        --------------------------------------------
        Delete Code
        --------------------------------------------
        --------------------------------------------*/
        $('body').on('click', '.deleteAccountInfo', function () {

            var product_id = $(this).data("id");
            confirm("Are You sure want to delete !");

            $.ajax({
                type: "DELETE",
                url: "{{ route('account-infos.store') }}" + '/' + product_id,
                success: function (data) {
                    table.draw();
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });

        //check_all
        $("#cq").click(function(){
            $(".cq").prop("checked",$(this).prop("checked"));
        })

      /*------------------------------------------
      --------------------------------------------
      Batch Delete Code
      --------------------------------------------
      --------------------------------------------*/
        $('#delete_selected').click(function() {
            if ($("input[name='test']:checked")[0] == null) {
                alert("please select records you want to delete!");
                return;
            }
            if (confirm("are you sure to delete these records？")) {

                var ids = new Array;
                $("input[name='test']:checked").each(function() {
                    ids.push($(this).val());
                    n = $(this).parents("tr").index() + 1;
                    $("table#dataTable").find("tr:eq(" + n + ")").remove();
                });
                console.log(ids);
                $.ajax({
                    url : "{{ route('account-infos.batchDelete') }}",
                    data : {data : JSON.stringify(ids)},
                    type : "POST",
                    dataType : "json",
                    success : function(data) {
                        console.log(data);
                        table.draw();
                    }
                });
            }
        })

      /*------------------------------------------
      --------------------------------------------
      Export Code
      --------------------------------------------
      --------------------------------------------*/
        $('#export').click(function() {
            if ($("input[name='test']:checked")[0] == null) {
                alert("please select records you want to export!");
                return;
            }
                var ids = new Array;
                $("input[name='test']:checked").each(function() {
                    ids.push($(this).val());
                    n = $(this).parents("tr").index() + 1;
                    $("table#dataTable").find("tr:eq(" + n + ")").remove();
                });
                console.log(ids);
                $.ajax({
                    url : "{{ route('account-infos.export') }}",
                    data : {data : JSON.stringify(ids)},
                    type : "POST",
                    dataType : "json",
                    success : function(data) {
                        console.log(data);
                        console.alert('1111');
                    }
                });

        })
    });
</script>
</html>
