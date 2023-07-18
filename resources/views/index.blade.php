<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRUD using Ajax</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon/ajax.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
      <center><h3 class="my-3"><img src="{{ asset('favicon/ajax.png') }}" width="60"> AJAX CRUD </h3></center>
      <h5 class="my-4">User Information</h5>
        <div class="row">

            <div class="col-8">
            <div class="input-group mb-5">
             <input type="text" class="form-control" placeholder="Search User" name="search" id="search">
             <span class="input-group-text" id="basic-addon2">Search</span>
            </div>
            
            <table class="table">
                <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Address</th>
      <th scope="col">Image</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
          <tbody id="content">
            <!-- <tr>
              <th scope="row">1</th>
              <td>Mark</td>
              <td>Otto</td>
              <td>@mdo</td>
              <td>Mark</td>
              <td>Otto</td>
              
            </tr> -->
             </tbody>
           </table>
            </div>
            <!-- add form -->
            <div class="col-3 mx-5" id="add_form">
            <h6 class="my-3" id="addHead">Add New Data</h6>    
 <form action="#" method="POST" id="add_data" enctype="multipart/form-data">
        @csrf
  <div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input type="text" class="form-control" name="name" required>
  </div>

  <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="text" class="form-control" name="email"  required>
  </div>

  <div class="mb-3">
    <label for="address" class="form-label">Address</label>
    <input type="text" class="form-control" name="address" required>
  </div>

  <div class="mb-3">
  <label for="image" class="form-label">Upload Image</label>
  <input class="form-control" type="file" name="image" >
  
</div>

  <button type="submit" id="add_btn" class="btn btn-primary">Add</button>
</form>
</div>
<!-- end add form -->
<!-- edit form --> 
<div id="edit_form" class="col-3 mx-5"> 
            <h6 class="my-3" id="updateHead">Update User Data</h6>    
 <form action="#" method="POST" id="update_data" enctype="multipart/form-data">
        @csrf
        <input type="hidden" class="form-control" name="user_id" id="user_id" required>
  <div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input type="text" class="form-control" name="name" id="name" required>
  </div>

  <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="text" class="form-control" name="email" id="email"  required>
  </div>

  <div class="mb-3">
    <label for="address" class="form-label">Address</label>
    <input type="text" class="form-control" name="address" id="address" required>
  </div>

  <div class="mb-2">
  <label for="image" class="form-label">Upload Image</label>
  <input class="form-control" type="file" name="newimage" id="newimage">
  <input class="form-control" type="hidden" name="oldimage" id="oldimage" >
  
</div>
  <div class="mb-3" id="image"></div>

  <button type="submit" id="update_btn" class="btn btn-primary">Update</button>
</form>
</div>
<!-- end edit form -->
            
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

      $('#add_form').show();
      $('#edit_form').hide();
     

        //display all data
        
        function fetchAllUsers()
        {
            $.ajax({
                url: '{{ route('fetchAll') }}',
                method: 'get',
                // dataType: 'json',
        
                success: function(response){
                    
                    let user = ""
                    $.each(response, function(key, value){
                      user += "<tr>"
                      user += "<td>"+ ++key +"</td>"
                      user += "<td>"+value.name+"</td>"
                      user += "<td>"+value.email+"</td>"
                      user += "<td>"+value.address+"</td>"
                      user += "<td><img class='rounded' src='{{ asset('images') }}/" + value.image + "' alt='User Image' width='80'></td>";
                      user += "<td>"
                      user += "<button class='btn btn-success btn-sm m-2 editData' id='"+value.id+"'>Edit</button>"
                      user += "<button class='btn btn-danger btn-sm deleteData' id='"+value.id+"'>Delete</button>"
                      user += "</td>"
                      user += "</tr>"
                    })
                    $('tbody').html(user);
                }

            });
        }

        fetchAllUsers();

        //insert data

        $("#add_data").submit(function(e){
            e.preventDefault();
            const fd = new FormData(this);
            $("#add_btn").text('Adding...');
            $.ajax({
                url: '{{ route('store') }}',
                method: 'post',
                data: fd, 
                cache: false,
                contentType: false,
                processData: false,
                success: function(res){
                  
                    if(res.status==200){
                        swal.fire(
                            'Added!',
                            'User Added Successfully',
                            'Success'
                        )
                    }
                    $("#add_btn").text('Add');
                    $("#add_data")[0].reset();
                    fetchAllUsers();
                }
            });

        })


        // edit data
        $(document).on('click', '.editData', function(e){
          e.preventDefault();
          let id = $(this).attr('id');
          $.ajax({
            method: "post",
            url: '{{ route('edit') }}',
            data:{
                id: id,
                _token: '{{ csrf_token() }}'
               },
            success: function(user){
              console.log(user);
              $('#add_form').hide();
              $('#edit_form').show();
              
              $('#user_id').val(user.id);
              $('#name').val(user.name);
              $('#email').val(user.email);
              $('#address').val(user.address);
              $('#newimage').val('');
              $('#oldimage').val(user.image);
              // $('#image').html(`<img src="{{asset('images/')}}${user.image}" width="100" class="img-fluid img-thumbnail">`);
              $('#image').html(`<img src="{{asset('images/${user.image}')}}" width="100" class="img-fluid img-thumbnail">`);

            }

          })
        });  


        // update data
        
        $("#update_data").submit(function(e){
          e.preventDefault();
          const fd = new FormData(this);
          $("#update_btn").text('Updating...');
          $.ajax({
            url: '{{ route('update') }}',
            method: 'post',
            data: fd,
            cache: false,
            processData: false,
            contentType: false,
            success: function(res){
              if(res.status==200){
                        swal.fire(
                            'Updated!',
                            'User Updated Successfully',
                            'Success'
                        )
                    }
                    $("#update_btn").text('Update');
                    $("#add_form").show();
                    $("#edit_form").hide();
                    fetchAllUsers();
            }
          });
        })

        // delete data

        $(document).on('click', '.deleteData', function(e){
          e.preventDefault();
          let id = $(this).attr('id');
          Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
               url: '{{ route('delete_data') }}',
               method: 'post',
               data:{
                id: id,
                _token: '{{ csrf_token() }}'
               },
               success: function(res){
                Swal.fire(
                   'Deleted!',
                   'User has been Deleted Successfully',
                   'Success'
                 )
                 fetchAllUsers();
               }
            });
          }
        });
        });


        //search user
        
        $(document).on('keyup', function(e){
          e.preventDefault();
          let search = $('#search').val();
          $.ajax({
            url: "{{ route('search') }}",
            method: 'GET',
            data: {search:search},
            success: function(response){

              if(response.status==250)
              {
                let user = ""
                    $.each(response, function(key, value){
                      user += "<tr>"
                      user += "<td></td>"
                      user += "<td></td>"
                      user += "<td></td>"
                      user += "<td class='text-danger'>Nothing Found</td>"
                      user += "<td></td>"
                      user += "<td></td>"
                      user += "</tr>"
                    })
                    $('tbody').html(user);
              }else{
                let user = ""
                    $.each(response, function(key, value){
                      user += "<tr>"
                      user += "<td>"+ ++key +"</td>"
                      user += "<td>"+value.name+"</td>"
                      user += "<td>"+value.email+"</td>"
                      user += "<td>"+value.address+"</td>"
                      user += "<td><img class='rounded' src='{{ asset('images') }}/" + value.image + "' alt='User Image' width='80'></td>";
                      user += "<td>"
                      user += "<button class='btn btn-success btn-sm m-2' onclick='editData("+value.id+")'>Edit</button>"
                      user += "<button class='btn btn-danger btn-sm deleteData' id='"+value.id+"'>Delete</button>"
                      user += "</td>"
                      user += "</tr>"
                    })
                    $('tbody').html(user);
              }
                    
                    
                }
          });
        })

        
          



    </script>

  </body>
</html>