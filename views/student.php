<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>CRUD Operation in CodeIgniter Using AJAX</title>
</head>
<body>
    <div class="container mt-2">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addStud">Add Student</button>
        <div class="modal" id="addStud">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Student</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="addStudFrm">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="name" class="form-control" name="name">
                            </div>
                            <div class="form-group">
                                <label>Date of birth</label>
                                <input type="date" class="form-control" name="dob">
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <textarea name="address" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Mobile No</label>
                                <input type="text" class="form-control" name="mobileno">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email">
                            </div>
                            <input type="submit" class="btn btn-primary">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="editStud">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Student</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="editStudFrm">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="name" class="form-control" name="name">
                            </div>
                            <div class="form-group">
                                <label>Date of birth</label>
                                <input type="date" class="form-control" name="dob">
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <textarea name="address" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Mobile No</label>
                                <input type="text" class="form-control" name="mobileno">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email">
                            </div>
                            <input type="hidden" name="sid" > 
                            <input type="submit" class="btn btn-primary">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="alert alert-dismissible mt-1"></div>
        <table class="table table-bordered" id="stud-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Date of birth</th>
                    <th>Mobile No</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>   
            </thead>
            <tbody>
            
            </tbody>
        </table>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            var baseurl="http://localhost/webapp/index.php/";
            $("#addStudFrm").submit(function(e){
                e.preventDefault();
                $.ajax({
                    url:baseurl+"student/addStudent",
                    type:'post',
                    data:$("#addStudFrm").serialize(),
                    success:function(r){
                        var data=$.parseJSON(r);
                        if(data.status==200){
                            $("#addStud").modal('hide');
                            $("#addStudFrm")[0].reset();
                            $(".alert").addClass("alert-success").html(`<button type="button" class="close" data-dismiss="alert">&times;</button><strong>Student Has been added successfully...</strong>`)
                            getStudents()
                        }else{
                            $("#addStud").modal('hide');
                            $(".alert").addClass("alert-danger").html(`<button type="button" class="close" data-dismiss="alert">&times;</button><strong>Something Wrong...</strong>`)
                        }

                    }
                })
            })
            function getStudents(){
                $.ajax({
                    url:baseurl+"student/getStudent",
                    success:function(r){
                        var data=$.parseJSON(r);
                        html='';
                        var no=1;
                        for(var i=0;i<data.length;i++){
                            html+=`
                                <tr>
                                    <td>${no}</td>
                                    <td>${data[i].name}</td>
                                    <td>${data[i].dob}</td>
                                    <td>${data[i].mobileno}</td>
                                    <td>${data[i].email}</td>
                                    <td>${data[i].address}</td>
                                    <td>
                                        <a href="javascript:void(0)" class="btn btn-success editstud" data-sid="${data[i].sid}" data-name="${data[i].name}" data-dob="${data[i].dob}" data-mobileno="${data[i].mobileno}" data-email="${data[i].email}" data-address="${data[i].address}" data-toggle="modal" data-target="#editStud">Edit</a>
                                         
                                        <a href="javascript:void(0)" class="btn btn-danger deletestud" data-sid="${data[i].sid}">Delete</a>
                                    </td>
                                </tr>
                            `
                            no++;
                        }
                        $("#stud-table tbody").html(html);

                    }
                })
            }
            getStudents()
            $(document).on("click",".editstud",function(){
                var link=$(this)
                $("#editStudFrm input[name=name]").val(link.data("name"))
                $("#editStudFrm input[name=dob]").val(link.data("dob"))
                $("#editStudFrm input[name=email]").val(link.data("email"))
                $("#editStudFrm input[name=mobileno]").val(link.data("mobileno"))
                $("#editStudFrm textarea[name=address]").val(link.data("address"))
                $("#editStudFrm input[name=sid]").val(link.data("sid"))
            })
            $("#editStudFrm").submit(function(e){
                e.preventDefault();
                $.ajax({
                    url:baseurl+"student/updateStudent",
                    type:'post',
                    data:$("#editStudFrm").serialize(),
                    success:function(r){
                        var data=$.parseJSON(r);
                        if(data.status==200){
                            $("#editStud").modal('hide');
                            $("#editStudFrm")[0].reset();
                            $(".alert").addClass("alert-success").html(`<button type="button" class="close" data-dismiss="alert">&times;</button><strong>Student Has been updated successfully...</strong>`)
                            getStudents()
                        }else{
                            $("#editStud").modal('hide');
                            $(".alert").addClass("alert-danger").html(`<button type="button" class="close" data-dismiss="alert">&times;</button><strong>Something Wrong...</strong>`)
                        }

                    }
                })
            })
            $(document).on("click",".deletestud",function(){
                var confirm=window.confirm('Are you sure remove this student detail ?')
                if(confirm){
                    var link=$(this)
                    $.ajax({
                        url:baseurl+"student/deleteStudent/"+link.data("sid"),
                        success:function(r){
                            var data=$.parseJSON(r);
                            if(data.status==200){
                                $("#editStud").modal('hide');
                                $("#editStudFrm")[0].reset();
                                $(".alert").addClass("alert-success").html(`<button type="button" class="close" data-dismiss="alert">&times;</button><strong>Student Has been deleted successfully...</strong>`)
                                getStudents()
                            }else{
                                $("#editStud").modal('hide');
                                $(".alert").addClass("alert-danger").html(`<button type="button" class="close" data-dismiss="alert">&times;</button><strong>Something Wrong...</strong>`)
                            }

                        }
                    })
                }
            })
        })
    </script>
</body>
</html>