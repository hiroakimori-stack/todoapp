@extends('layouts.app')
@section('content')

<style>
    input[type="button"],
    .trash-area,
    .body-area{
        cursor: pointer;
    }
    .trash-area:hover{
        opacity: 0.5;
    }
</style>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">
                <label for="task-input">New Task</label>
                <div class="form-group d-flex mb-4">
                    {{-- @csrf --}}
                    <input type="text" name="task" id="task-input" class=" form-control mr-3">
                    <input type="button" value="追加" onClick="createTask()" class="btn btn-outline-primary mx-3">
                </div>
                <table class="w-100 table table-hover">
                    <thead>
                        <tr>
                            <th><i class="fas fa-check-square"></i></th>
                            <th>タスク</th>
                            <th>日付</th>
                            <th class="float-end">ゴミ箱へ</th>
                        </tr>
                    </thead>
                    <tbody class="tr_lists">

                    @foreach ($posts as $post)
                        <tr id="tr_{{$post->id}}" class="@if($post->complete_flag == 1) bg-success  @endif">
                            <td><input type="checkbox" name="task-done" id="checkbox_{{$post->id}}" onChange="checkChange( {{$post->id}} )" @checked></td>
                            <td class="w-50"><label for="checkbox_{{$post->id}}"><span class="body-area">{{$post->text}}</span></label></td>
                            <td><span class="date-area">{{$post->create_time}}</span></td>
                            
                            <td><span class="trash-area float-end" onClick="goToTrash({{$post->id}})"><i class="fas fa-trash fa-2xl"></i></span></td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

<script>
    function createTask() {

        const task = $("#task-input").val();

        console.log(task);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

       $.ajax({
        type: 'post',
        data: {
                'task' : task
             },
        datatype: 'json',
            url: '/create'
            })
            .done(function(data){
                // console.log(data.post);

                $("#task-input").val('');

                for (let i = 0; i < data.post.length; i++) {
                    const element = data.post[i];
                    // console.log(element);
                    var el = '';
                    el+= '<tr id="tr_'+element.id+'" class="">';
                    el+= '<td><input type="checkbox" name="task-done" id="checkbox_'+element.id+'" onChange="checkChange('+element.id+')"></td>';
                    el+= '<td class="w-50"><label for="checkbox_'+element.id+'"><span class="body-area">'+element.text+'</span></label></td>';
                    el+= '<td><span class="date-area">'+element.create_time+'</span></td>';
                    el+= '<td><span class="trash-area float-end" onClick="goToTrash('+element.id+')"><i class="fas fa-trash fa-2xl"></i></span></td>';
                    el+= '</tr>';
                    $('tbody.tr_lists').prepend(el);
                }
                })
            .fail(function(data){
                // console.log(data);
                alert("error!");
            });
    }

function goToTrash(id) {

    console.log(id);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
    type: 'post',
    data: {
            'id' : id
            },
    datatype: 'json',
        url: '/softdelete'
        })
        .done(function(data){
            // console.log(data);
            $('#tr_'+id).remove();
        })
        .fail(function(data){
            // console.log(data);
            alert("error!");
        });
    }

    function checkChange(id) {
    
    var is_checked = $('#checkbox_'+id).prop("checked");
    
    $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
    
    $.ajax({
    type: 'post',
    data: {
    'id' : id,
    'is_checked' : is_checked
    },
    datatype: 'json',
    url: '/check/change'
    })
    .done(function(data){
        // console.log(data);
        if(data == 1){
            $('#tr_'+id).addClass('bg-success');
        }else{
            $('#tr_'+id).removeClass('bg-success');
        }
    })
    .fail(function(data){
    // console.log(data);
    alert("error!");
    });
    }
</script>
@endsection