<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <div class="main-section">
        <div class="add-section">
            <form >
                <input type="text" name="title" id="title" placeholder="What de you need to do?"/>
                <button id="add">Add &nbsp; <span>&#43;</span></button>
            </form>
        </div>
        <div class="show-todo-section">
     
        </div>
    </div>
</body>
</html>
<script
  src="https://code.jquery.com/jquery-3.6.1.min.js"
  integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="
  crossorigin="anonymous"></script>

  <script>

    $(document).ready(function(){
        function loadList(){
            $.ajax({
            url:'php/todos.php',
            method:'post',
            async:false,
            success:function(response){
                console.log(response)

                var data =JSON.parse(response)
                var todos=""
                if(data.length>0){
                    for (let i = 0; i < data.length; i++) {
                  var checked=""
                  var checked_class_input=""
                  var checked_title=""
                  if(data[i].checked){
                    checked="checked";
                  
                    checked_title="checked"
                  }
                  todos+='<div class="todo-item"><span id="delete" class="remove-to-do"  data="'+data[i].id+'">x</span> <input  data="'+data[i].id+'" class="check-box"  '+checked+' type="checkbox" /><h2 class="'+checked_title+'">'+data[i].title+' </h2><br/><small>created:'+data[i].date_time+'</small></div>'
              }   $('.show-todo-section').append(todos)
           
                }else{
                    todos+='<div class="todo-item"><div class="empty"><img src="img/loadingDots.gif" width="300px"/></div></div>'
                    $('.show-todo-section').append(todos)
                }
             
            }
        })

        }

        loadList()

        $('#add').click(function(e){
e.preventDefault()
            var title=$('#title').val()
            if(title==""){
                alert('remplir le champs')
            }else{
                $.ajax({
                    url:'php/add.php',
                    method:'post',
                    async:false,
                    data:{title:title},
                    success:function(response){
                        $('.show-todo-section').empty()
                        loadList()
                    }
                })
            }
        })

        $(document).on('click','#delete',function(){
            var id=$(this).attr('data');
            $.ajax({
                url:'php/delete.php',
                method:'post',
                async:false,
                data:{id:id},
                success:function(response){
                    $('.show-todo-section').empty()
                    loadList()
                   //$(this).parent().hide(600)
                }
            })

        })
        $(document).on('click','.check-box',function(){
            var id=$(this).attr('data');
            $.ajax({
                url:'php/checked.php',
                method:'post',
                async:false,
                data:{id:id},
                success:function(response){
                    $('.show-todo-section').empty()
                    loadList()
                   //$(this).parent().hide(600)
                }
            })

        })

    })
  </script>