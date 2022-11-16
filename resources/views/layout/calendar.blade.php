@extends('layout.main')
@section('css')
<link rel="stylesheet" href="{{asset('/assets/plugins/fullcalendar/main.min.css')}}">
<link rel="stylesheet" href="{{asset('/assets/plugins/fullcalendar-daygrid/main.min.css')}}">
<link rel="stylesheet" href="{{asset('/assets/plugins/fullcalendar-timegrid/main.min.css')}}">
<link rel="stylesheet" href="{{asset('/assets/plugins/fullcalendar-bootstrap/main.min.css')}}">
<link rel="stylesheet" href="{{asset('/assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}">
@endsection
@section('content')
<div class="row">

    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <button class="btn btn-warning" data-toggle="modal" data-target="#addeventmodal">Tambah Event</button>
                @if(Session::get('dept')== 'PGA'||Session::get('level')=='Admin')

                <button class="btn btn-danger" data-toggle="modal" data-target="#holmodal">Holiday</button>
                @endif
            </div>
            <div class="card-body p-0">
                <!-- THE CALENDAR -->
                <div id="calendar"></div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<div class="modal fade" id="addeventmodal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <div class="container-fluid">

                    <form id="createEvent" class="form-horizontal">

                        <div class="row">

                            <div class="col-md-6">

                                <div id="title-group" class="form-group">
                                    <label class="control-label" for="title">Title</label>
                                    <input type="text" class="form-control" name="title" required>
                                    <!-- errors will go here -->
                                </div>

                                <div id="startdate-group" class="form-group">
                                    <label class="control-label" for="startDate">Start Date</label>
                                    <input type="datetime-local" class="form-control datetimepicker" id="startDate"
                                        name="startDate" required>
                                    <!-- errors will go here -->
                                </div>

                                <div id="enddate-group" class="form-group">
                                    <label class="control-label" for="endDate">End Date</label>
                                    <input type="datetime-local" class="form-control datetimepicker" id="endDate"
                                        name="endDate" required>
                                    <!-- errors will go here -->
                                </div>

                            </div>

                            <div class="col-md-6">

                                <div id="color-group" class="form-group">
                                    <label class="control-label" for="color">Colour</label>
                                    <input type="text" class="form-control my-colorpicker1 colorpicker-element"
                                        data-colorpicker-id="1" data-original-title="" title="" name="color"
                                        value="#6453e9" required>

                                    <!-- errors will go here -->
                                </div>

                                <div id="textcolor-group" class="form-group">
                                    <label class="control-label" for="textcolor">Text Colour</label>
                                    <input type="text" class="form-control my-colorpicker1 colorpicker-element"
                                        name="text_color" value="#ffffff" required>
                                    <!-- errors will go here -->
                                </div>
                                <div id="textcolor-group" class="form-group">
                                    <label class="control-label" for="tag">Tag</label>
                                    <select name="tag" id="tag" class="form-control">
                                        <option value="public">Public</option>
                                        <option value="private">Private</option>

                                    </select>
                                    <!-- errors will go here -->
                                </div>

                            </div>

                        </div>



                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>

            </form>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="editeventmodal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Update Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <div class="container-fluid">

                    <form id="editEvent" class="form-horizontal">
                        <input type="hidden" id="editEventId" name="editEventId" value="">

                        <div class="row">

                            <div class="col-md-6">

                                <div id="edit-title-group" class="form-group">
                                    <label class="control-label" for="editEventTitle">Title</label>
                                    <input type="text" class="form-control" id="editEventTitle" name="editEventTitle">
                                    <!-- errors will go here -->
                                </div>

                                <div id="edit-startdate-group" class="form-group">
                                    <label class="control-label" for="editStartDate">Start Date</label>
                                    <input type="datetime-local" class="form-control datetimepicker" id="editStartDate"
                                        name="editStartDate">
                                    <!-- errors will go here -->
                                </div>

                                <div id="edit-enddate-group" class="form-group">
                                    <label class="control-label" for="editEndDate">End Date</label>
                                    <input type="datetime-local" class="form-control datetimepicker" id="editEndDate"
                                        name="editEndDate">
                                    <!-- errors will go here -->
                                </div>

                            </div>

                            <div class="col-md-6">

                                <div id="edit-color-group" class="form-group">
                                    <label class="control-label" for="editColor">Colour</label>
                                    <input type="text" class="form-control my-colorpicker1 colorpicker-element"
                                        id="editColor" name="editColor" value="#6453e9">
                                    <!-- errors will go here -->
                                </div>

                                <div id="edit-textcolor-group" class="form-group">
                                    <label class="control-label" for="editTextColor">Text Colour</label>
                                    <input type="text" class="form-control my-colorpicker1 colorpicker-element"
                                        id="editTextColor" name="editTextColor" value="#ffffff">
                                    <!-- errors will go here -->
                                </div>
                                <div id="textcolor-group" class="form-group">
                                    <label class="control-label" for="tag">Tag</label>
                                    <select name="tag" id="edit_tag" class="form-control">
                                        <option value="public">Public</option>
                                        <option value="private">Private</option>
                                    </select>
                                    <!-- errors will go here -->
                                </div>

                            </div>

                        </div>

                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
                <button type="button" class="btn btn-danger" id="deleteEvent" data-id>Delete</button>
            </div>

            </form>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="holmodal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Holiday</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <div class="container-fluid">

                    <form id="holform" class="form-horizontal">

                        <div class="row">

                            <div class="col-md-6">
                                <div id="startdate-group" class="form-group">
                                    <label class="control-label" for="startDate">Start Date</label>
                                    <input type="date" class="form-control datetimepicker" id="holstart" name="holstart"
                                        required>
                                    <!-- errors will go here -->
                                </div>


                            </div>
                            <div class="col-md-6">

                                <div id="enddate-group" class="form-group">
                                    <label class="control-label" for="endDate">End Date</label>
                                    <input type="date" class="form-control datetimepicker" id="holend" name="holend"
                                        required>
                                    <!-- errors will go here -->
                                </div>
                            </div>

                        </div>



                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>

            </form>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
@endsection
@section('script') <script src="{{asset('/assets/plugins/select2/js/select2.full.min.js')}}">
</script>
<script src="{{asset('/assets/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('/assets/plugins/fullcalendar/main.min.js')}}"></script>
<script src="{{asset('/assets/plugins/fullcalendar-daygrid/main.min.js')}}"></script>
<script src="{{asset('/assets/plugins/fullcalendar-timegrid/main.min.js')}}"></script>
<script src="{{asset('/assets/plugins/fullcalendar-interaction/main.min.js')}}"></script>
<script src="{{asset('/assets/plugins/fullcalendar-bootstrap/main.min.js')}}"></script>
<script src="{{asset('/assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>
<script>
    $(document).ready(function(){
        var key = localStorage.getItem('npr_token');
      /* initialize the external events
       -----------------------------------------------------------------*/
    
  
      /* initialize the calendar
       -----------------------------------------------------------------*/
      //Date for the calendar events (dummy data)
      var date = new Date()
      var d    = date.getDate(),
          m    = date.getMonth(),
          y    = date.getFullYear()
  
      var Calendar = FullCalendar.Calendar;
      var Draggable = FullCalendarInteraction.Draggable;
  
      var calendarEl = document.getElementById('calendar');
  
      // initialize the external events
      // -----------------------------------------------------------------
  
  
      var calendar = new Calendar(calendarEl, {
        plugins: [ 'bootstrap', 'interaction', 'dayGrid', 'timeGrid' ],
        header    : {
          left  : 'prev,next today',
          center: 'title',
          right : 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        //Random default events
        eventSources    :[
            {
                events: function(start, callback){
         
                    $.ajax({
                        url: APP_URL+'/api/calendar/load',
                        method: 'POST',
                        headers: { 'token_req': key },
                        data : {start},
                        success: function (response) {
                                var events = [];
                                $(response).each(function () {
                                   
                                events.push({
                                    id: $(this).attr('id_calendar'),
                                    title: $(this).attr('title'),
                                    start: new Date($(this).attr('start_event')),
                                    end: new Date($(this).attr('end_event')),
                                    backgroundColor: $(this).attr('color'),
                                    textColor : $(this).attr('text_color'),
                                    allday : false,
                                });
                            });
                            callback(events);
                        }
                    });
                }
          
        }],
        
       
        editable  : true,
        droppable : true, // this allows things to be dropped onto the calendar !!!
        eventDrop : function(arg){
           
            var start = moment(arg.event.start).format('YYYY-MM-DD hh:mm:ss');
            if (arg.event.end == null) {
                end = start;
            } else {
              
                var end = moment(arg.event.end).format('YYYY-MM-DD hh:mm:ss');
            }
            $.ajax({
            url:APP_URL+'/api/calendar/update',
            type:"POST",
            headers: { 'token_req': key },
            data:{"id":arg.event.id, "start":start, "end":end},
            });
            calendar.refetchEvents();  
        },
        /*
        eventResize : function(arg){
          
            var start = moment(arg.event.start).format('YYYY-MM-DD hh:mm:ss');
            var end = moment(arg.event.end).format('YYYY-MM-DD hh:mm:ss');
            $.ajax({
            url:APP_URL+'/api/calendar/update',
            type:"POST",
            headers: { 'token_req': key },
            data:{"id":arg.event.id, "start":start, "end":end},
            });
        },
        */
        eventClick : function(arg){
            var id = arg.event.id;
    
            $('#editEventId').val(id);
            $('#deleteEvent').attr('data-id', id); 

            $.ajax({
            url:APP_URL+'/api/calendar/getevent',
            type:"POST",
            headers: { 'token_req': key },
            dataType: 'json',
            data:{"id":id},
            success: function(resp) {
                var start = moment(resp.data.start_event).format('YYYY-MM-DDThh:mm:ss.SSS');
                var end = moment(resp.data.end_event).format('YYYY-MM-DDThh:mm:ss.SSS');
                    $('#editEventTitle').val(resp.data.title);
                    $('#editStartDate').val(start);
                    $('#editEndDate').val(end);
                    $('#editColor').val(resp.data.color);
                    $('#editTextColor').val(resp.data.text_color);
                    $('#edit_tag option[value="'+resp.data.tag+'"').prop('selected', true);
                    $('#editeventmodal').modal('show');
                }
            });

            $('body').on('click', '#deleteEvent', function() {
                if(confirm("Apakah anda akan menghapus event ini?")) {
                    $.ajax({
                        url:APP_URL+'/api/calendar/delete',
                        type:"POST",
                        headers: { 'token_req': key },
                        data:{"id":arg.event.id},
                        success : function(resp){
                        //alert(resp.message);
                        $('#editeventmodal').modal('hide');
                        }
                    }); 

                  
                    calendar.refetchEvents();         
                }
            });
            
            calendar.refetchEvents();
        },
      });
  
      calendar.render();
      // $('#calendar').fullCalendar()
  
      /* ADDING EVENTS */
      //var currColor = '#3c8dbc' //Red by default
      //Color chooser button
    $(".my-colorpicker1").colorpicker();
    $("#createEvent").submit(function(e){
        e.preventDefault();
        var data = $(this).serialize();
        $.ajax({
                url: APP_URL+'/api/calendar/create',
                type: 'POST',
                dataType: 'json',
                headers: { "token_req": key },
                data: data,
                })
                .done(function(resp) {
                    if (resp.success) {
                       
                        alert(resp.message);
                        $('#createEvent').trigger("reset");
                        $('#addeventmodal').modal('hide');
                        calendar.refetchEvents();
                    }
                    else
                   alert(resp.message);
                })
                .fail(function() {
                    $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");
                   
                })
                .always(function() {
                  
                });
    });

    $("#editEvent").submit(function(e){
        e.preventDefault();
        //var data = $(this).serialize();
        var id = $('#editEventId').val();
        var title = $('#editEventTitle').val();
        var start = $('#editStartDate').val();
        var end = $('#editEndDate').val();
        var color = $('#editColor').val();
        var textColor = $('#editTextColor').val();
        var tag = $('#edit_tag').val();
        $.ajax({
                url: APP_URL+'/api/calendar/update',
                type: 'POST',
                dataType: 'json',
                headers: { "token_req": key },
                data: {
                    id:id, 
                    title:title, 
                    start:start,
                    end:end,
                    color:color,
                    text_color:textColor,
                    tag:tag,
                },
                })
                .done(function(resp) {
                    if (resp.success) {
                       
                        alert(resp.message);
                        $('#editEvent').trigger("reset");
                        $('#editeventmodal').modal('hide');
                        calendar.refetchEvents();
                    }
                    else
                   alert(resp.message);
                })
                .fail(function() {
                    $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");
                   
                })
                .always(function() {
                  
                });
    });
    $("#holform").submit(function(e){
        e.preventDefault();
      
        var data = $(this).serialize();
        $.ajax({
                url: APP_URL+'/api/calendar/holiday',
                type: 'POST',
                dataType: 'json',
                headers: { "token_req": key },
                data: data,
                })
                .done(function(resp) {
                    if (resp.success) {
                       
                        alert(resp.message);
                        $('#holform').trigger("reset");
                        $('#holmodal').modal('hide');
                        calendar.refetchEvents();
                    }
                    else
                   alert(resp.message);
                })
                .fail(function() {
                    $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");
                   
                })
                .always(function() {
                  
                });
                
    });
     
    });
   
   
</script>
@endsection