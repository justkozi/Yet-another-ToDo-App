// Funkcje AJAX'owe




function getToDosAJAX() {
    $.ajax({
        type: "POST",
        url: "/ajax/todo.php",
        data: {action: 'getToDo'},
        dataType:'JSON',
        success: function(response){
            if(response.status == "success")
            {
                $.each(response.data, function (i,item) {
                    createToDo(item);
                })
            }else{
                console.log(response.response)
            }
        }
    });
}

function getTasksAJAX(todo_id) {
    $.ajax({
        type: "POST",
        url: "/ajax/todo.php",
        data: {action: 'getTasks',id:todo_id},
        dataType:'JSON',
        success: function(response){
            if(response.status == "success")
            {
                $(".todo#todo_"+todo_id+" table").empty();
                $.each(response.data, function (i,item) {
                    insertTask(todo_id,item);
                })
                insertTaskAdd(todo_id,true);
            }else{
                console.log(response.response)
            }
        }
    });
}

function swapTasksAJAX(id_task1, id_task2) {
    var stat=false;

    function ajax_swap() {
        return $.ajax({
            type: "POST",
            url: "/ajax/todo.php",
            data: {action: 'swapTasks',id1:id_task1,id2:id_task2},
            dataType:'JSON',
            success: function(response){
                if(response.status == "success")
                {
                    stat = true;
                    // console.log(stat);
                }else{
                    console.log(response.response);
                    // return false;
                }
            }
        });
    }
    $.when(ajax_swap()).done(function a() {
        return stat;
    })
}

function changeTaskStatusAJAX(task_id) {
    $.ajax({
        type: "POST",
        url: "/ajax/todo.php",
        data: {action: 'changeTaskStatus',id:task_id},
        dataType:'JSON',
        success: function(response){
            if(response.status == "success")
            {

            }else{
                console.log(response.response)
            }
        }
    });
}

function changeTaskContentAJAX(task_id, task_content) {
    $.ajax({
        type: "POST",
        url: "/ajax/todo.php",
        data: {action: 'changeTaskContent',id:task_id,content:task_content},
        dataType:'JSON',
        success: function(response){
            if(response.status == "success")
            {

            }else{
                console.log(response.response)
            }
        }
    });
}

function removeTaskAJAX(task_id) {
    $.ajax({
        type: "POST",
        url: "/ajax/todo.php",
        data: {action: 'removeTask',id:task_id},
        dataType:'JSON',
        success: function(response){
            if(response.status == "success")
            {

            }else{
                console.log(response.response)
            }
        }
    });
}

function addTask(id_todo,task_content) {
    var free_id = NaN;
    $.ajax({
        type: "POST",
        url: "/ajax/todo.php",
        data: {action: 'addTask',idToDo: id_todo,content:task_content},
        dataType:'JSON',
        success: function(response){
            if(response.status == "success")
            {
                removeTaskAdd(response.data['Id_todo']);
                insertTask(response.data['Id_todo'],response.data);
                insertTaskAdd(response.data['Id_todo'],true);
            }else{
                console.log(response.response)
            }
        }
    });

    if(!isNaN(free_id)){
        return free_id;
    }else{
        return false;
    }
}

function changeToDoTitleAJAX(id_todo,new_title) {
    $.ajax({
        type: "POST",
        url: "/ajax/todo.php",
        data: {action: 'changeToDoTitle',idToDo: id_todo,title: new_title},
        dataType:'JSON',
        success: function(response){
            if(response.status == "success")
            {

            }else{
                console.log(response.response)
            }
        }
    });
}

function removeToDoAJAX(id_todo) {
    $.ajax({
        type: "POST",
        url: "/ajax/todo.php",
        data: {action: 'removeToDo',idToDo: id_todo},
        dataType:'JSON',
        success: function(response){
            if(response.status == "success")
            {

            }else{
                console.log(response.response)
            }
        }
    });
}

function addToDoAJAX(todo_title,todo_cat_id) {
    $.ajax({
        type: "POST",
        url: "/ajax/todo.php",
        data: {action: 'addToDo',title: todo_title, cat_id:todo_cat_id},
        dataType:'JSON',
        success: function(response){
            if(response.status == "success")
            {
                createToDo(response.data);
            }else{
                console.log(response.response)
            }
        }
    });
}



// Funkcje tworzące strukturę dokumentu, oraz obsługujące zdarzenia




// Tworzy To-do o podanym id
function createToDo(ToDo) {
    $(".todo-wrapper").append(
        '<div class="todo cat_'+ToDo.Cat_id+'" id="todo_'+ToDo.ID+'">' +
        '<div class="todo-header"> ' +
        '<h2 class="title">'+ToDo.Title+'</h2> ' +
        '<span class="add-date">Dodano: '+ToDo.Add_date+'</span> ' +
        '<div class="menu"> ' +
        '<div class="nav"> ' +
        '<div class="move-up"><i class="fa fa-caret-up" aria-hidden="true"></i></div> ' +
        '<div class="move-down"><i class="fa fa-caret-down" aria-hidden="true"></i></div> ' +
        '</div> ' +
        '<div class="actions"> ' +
        '<div class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></div> ' +
        '<div class="delete"><i class="fa fa-trash-o" aria-hidden="true"></i></div> ' +
        '</div> ' +
        '</div> ' +
        '<div class="show-tasks"><i class="fa fa-chevron-down" aria-hidden="true"></i></div> ' +
        '</div>' +
        '<div class="todo-tasks" style="display: none;"><table>' +
        '</table></div></div>'
    );
    $("#todo_"+ToDo.ID+" .show-tasks").on('click', function () {
        loadTasks(this);
        taskToggleClick(this);
    });
    $("#todo_"+ToDo.ID+" .move-up").on('click', function () {
        moveToDoUp($("#todo_"+ToDo.ID));
    });
    $("#todo_"+ToDo.ID+" .move-down").on('click', function () {
        moveToDoDown("#todo_"+ToDo.ID);
    });
    $("#todo_"+ToDo.ID+" .edit").on('click', function () {
        editToDoTitle("#todo_"+ToDo.ID);
    });
    $("#todo_"+ToDo.ID+" .title").on('dblclick', function () {
        editToDoTitle("#todo_"+ToDo.ID);
    });
    $("#todo_"+ToDo.ID+" .delete").on('click', function () {
        removeToDo("#todo_"+ToDo.ID)
    });


}

function insertTask(todo_id,task) {
    var done_status = '';
    var icon = 'fa-square-o';
    if(task.Done) {
        done_status = 'done';
        icon = 'fa-check';
    }

    $(".todo#todo_"+todo_id+" table").append(
            '<tr class="task '+done_status+'" id="task_'+task.Id_task+'"> ' +
            '<td class="check-box-cell"> ' +
            '<div class="check-box"><i class="fa '+icon+'" aria-hidden="true"></i></div> ' +
            '</td> ' +
            '<td class="content-cell"> ' +
            '<span class="content">'+task.Content+'</span> ' +
            '</td> ' +
            '<td class="edit-box-cell">' +
            '<div class="edit-box"><i class="fa fa-pencil" aria-hidden="true"></i></div> ' +
            '</td> ' +
            '<td class="del-box-cell"> ' +
            '<div class="del-box"><i class="fa fa-trash-o" aria-hidden="true"></i></div> ' +
            '</td> ' +
            '</tr>'
    );

    $("#task_"+task.Id_task+" .check-box-cell").on('click', function () {
        var clickedTaskId = Number($(this).parent().attr('id').replace('task_',''));
        changeTaskStatusAJAX(clickedTaskId);
        toggleDoneTask(this);
    });
    $("#task_"+task.Id_task+" .edit-box-cell").on('click', function () {
        editTask(this);
    });
    $("#task_"+task.Id_task+" .content-cell").on('dblclick', function () {
        editTask(this);
    });
    $("#task_"+task.Id_task+" .del-box-cell").on('click', function () {
        removeTask(this);
    });
}

function insertTaskAdd(todo_id,focus) {
        $(".todo#todo_"+todo_id+" table").append(
            '<tr class="task add-task" > ' +
            '<td></td> ' +
            '<td class="input-cell"> ' +
            '<input name="input-content" type="text" placeholder="Dodaj nową notatkę..."> ' +
            '</td> ' +
            '<td class="add-box-cell"> ' +
            '<div class="add-box"><i class="fa fa-plus" aria-hidden="true"></i></div> ' +
            '</td><td></td>' +
            '</tr>'
        );
        if(focus == true){
            // console.log($(".todo#todo_"+todo_id+" table .add-task"));
            $(".todo#todo_"+todo_id+" table .add-task input")[0].focus();
        }
        $(".todo#todo_"+todo_id+" .add-box-cell").on('click',function () {
            var new_task_content = $(".todo#todo_"+todo_id+" .add-task input")[0].value;
            if(new_task_content.length > 0){
                free_id = getFreeTaskIdAJAX(todo_id);
                if(free_id){
                    var task = {
                        Id_task : free_id,
                        Content : new_task_content,
                        Done    : 0
                    }
                    insertTask(todo_id,task);
                    changeTaskContentAJAX(free_id,new_task_content);
                    removeTaskAdd(todo_id);
                    insertTaskAdd(todo_id,true);
                }
            }
        })
        $(".todo#todo_"+todo_id+" .input-cell input").keypress(function (e) {
            if(e.which == 13){
                var new_task_content = $(".todo#todo_"+todo_id+" .add-task input")[0].value;
                if(new_task_content.length > 0){
                    addTask(todo_id,new_task_content);
                }
            }
        })
}
function removeTaskAdd(todo_id) {
    $(".todo#todo_"+todo_id+" table .add-task").remove();
}



// Funkcje wywoływane poprzez zdarzenia i wywołujące zapytania AJAX'owe



var prev_title;
function editToDoTitle(element) {
    var clicked_id = Number(element.replace('#todo_',''));
    if($(element+" .edit i").hasClass('fa-pencil')){
        var title = $(element+" .title")[0].innerHTML;
        prev_title=title;
        $(element+" .title").replaceWith("<input type='text' class='title'>");
        $(element+" .title")[0].focus();
        $(element+" .title")[0].value = title;
        $(element+" .edit i").removeClass('fa-pencil').addClass('fa-plus');
        $(element+" .title").keypress(function (e) {
            if(e.which == 13){
                editToDoTitle(element);
            }
        })
    }else{
        var new_title = $(element+" .title")[0].value;
        if(new_title != prev_title){
            changeToDoTitleAJAX(clicked_id,new_title);
        }
        $(element+" .title").replaceWith("<h2 class=\"title\">"+new_title+"</h2>");
        $(element+" .edit i").removeClass('fa-plus').addClass('fa-pencil');

        $(element+" .title").on('dblclick', function () {
            editToDoTitle(element);
        });
    }
}

function removeToDo(element) {
    var clicked_id = Number(element.replace('#todo_',''));
    $(element).remove();
    removeToDoAJAX(clicked_id);
}

function moveToDoUp(element) {
    if($(element).prev().length){
        var this_id = $(element).attr('id').replace('todo_','');
        var prev_id = $(element).prev().attr('id').replace('todo_','');

        swapTasksAJAX(this_id, prev_id);
            $(element).hide().insertBefore($(element).prev()).slideDown(300);
        }
        // console.log(this_id +'->'+prev_id );
}

function moveToDoDown(element) {
    if($(element).next().length){
        var this_id = $(element).attr('id').replace('todo_','');
        var prev_id = $(element).next().attr('id').replace('todo_','');

        swapTasksAJAX(this_id, prev_id);
            $(element).hide().insertAfter($(element).next()).slideDown(300);

        // console.log(this_id +'->'+prev_id );
    }
}

// Pokazuje zadania i obraca symbol
function taskToggleClick(element) {
    $(element).parent().next(".todo-tasks").slideToggle();
    $(element).toggleClass("fliped");
}

function loadTasks(element) {
    var status = ($(element).hasClass('fliped') ? 1 : 0);
    var clickedTodoId = Number($(element).parent().parent().attr('id').replace('todo_',''));
    var preloaded = ($('#todo_'+clickedTodoId).hasClass('loaded') ? 1 : 0); // Sprawdza czy zostały już wcześniej załadowane/pokazane zadania.
    if(!status){ // Status 0 oznaczał że było zamknięte
        if(!preloaded){
            showTasks(status,clickedTodoId);
        }
    }
}
// Funkcja pokazuje zadania jeśli nie zostały wczytane
function showTasks(status,idToDo) {
    getTasksAJAX(idToDo);
    $('#todo_'+idToDo).addClass('loaded'); // Ustala że zadania zostały pokazane i pobrane
}


function editTask(element) {
    var clickedTaskId = Number($(element).parent().attr('id').replace('task_',''));
    $.each($(".content"),function (i,item) {
        $(item).width($("#todos").width()-120);
    })

    if($("#task_"+clickedTaskId+" .edit-box-cell i").hasClass('fa-pencil')){
        var content_text = $("#task_"+clickedTaskId+" .content")[0].innerHTML;
        $("#task_"+clickedTaskId+" .content-cell")[0].innerHTML = "<input type=\"text\" value=\""+content_text+"\" class=\"content content-input\"/>";
        $("#task_"+clickedTaskId+" .edit-box-cell i").removeClass('fa-pencil').addClass('fa-plus');
        $("#task_"+clickedTaskId+" .content-input")[0].focus();
        $("#task_"+clickedTaskId+" .content-input")[0].value = content_text;
        $("#task_"+clickedTaskId+" .content-input").keypress(function (e) {
            if(e.which == 13){
                editTask(element);
            }
        })
        // $("#task_"+clickedTaskId+" .content-input").focusout(function () {
        //     editTask(element);
        // })
    }else{
        var inputed_text = $("#task_"+clickedTaskId+" .content-input")[0].value;
        var curr_width = $($("#task_"+clickedTaskId+" .content-input")[0]).width();

        changeTaskContentAJAX(clickedTaskId, inputed_text);

        $("#task_"+clickedTaskId+" .edit-box-cell i").removeClass('fa-plus').addClass('fa-pencil');
        $("#task_"+clickedTaskId+" .content-cell")[0].innerHTML = "<span class=\"content\">"+inputed_text+"</span>";

        $($("#task_"+clickedTaskId+" .content")[0]).width(curr_width);
    }
}

// Zaznacza/odznacza zadanie
function toggleDoneTask(element) {
    if($(element).children().children().hasClass('fa-check')){
        $(element).children().children().removeClass('fa-check').addClass('fa-square-o');
        $(element).parent().removeClass("done")

    }else{
        $(element).children().children().addClass('fa-check').removeClass('fa-square-o');
        $(element).parent().addClass("done")
    }
}

function removeTask(element) {
    var clickedTaskId = Number($(element).parent().attr('id').replace('task_',''));
    removeTaskAJAX(clickedTaskId);
    $("#task_"+clickedTaskId).remove();
}





// Pozostałe funkcje




// Get to-do's
$(function () {
    getToDosAJAX();
    $(document).ready(function(){
        $.each($(".content"),function (i,item) {
            $(item).width($("#todos").width()-120);
        })
        $(window).resize(function(){
            $.each($(".content"),function (i,item) {
                $(item).width($("#todos").width()-120);
            })

        });
    });
    $("#refresh").on('click',function () {
        $(".todo-wrapper").empty();
        getToDosAJAX();
    })

    $(document).on('change', '.add-todo select', function(e) {
        var cur_val = this.options[e.target.selectedIndex].value;
        $('.add-todo')[0].classList = ['add-todo'];
        $('.add-todo').addClass(cur_val);
    });


    $('.add-todo .fa-plus').on('click',function () {
        var new_todo_title = $('.add-todo input')[0].value;
        if(new_todo_title.length>0){
            var cat = Number($('.add-todo')[0].classList[1].replace('cat_',''));
            addToDoAJAX(new_todo_title,cat);
            $('.add-todo input')[0].value = '';
        }
    })

    $('.add-todo input').keypress(function (e) {
        if(e.which == 13){
            var new_todo_title = $('.add-todo input')[0].value;
            if(new_todo_title.length>0){
                var cat = Number($('.add-todo')[0].classList[1].replace('cat_',''));
                addToDoAJAX(new_todo_title,cat);
                $('.add-todo input')[0].value = '';
            }
        }
    })
})
