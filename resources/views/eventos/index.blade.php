@extends('layouts.app')

@section('scripts')
    <link rel="stylesheet" href="{{ asset('fullcalendar/lib/main.css') }}">

    <script src="{{ asset('fullcalendar/lib/main.js') }}" defer></script>

    <script>


      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {


            initialDate: '2020-11-01',
            initialView: 'dayGridMonth',
            nowIndicator: true,
            headerToolbar: {
            left: 'prev,next today, Button, ModalButton',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
            navLinks: true,
            editable: true,
            selectable: true,
            selectMirror: true,
            dayMaxEvents: true,
            customButtons:{
                Button:{
                    text:"Return",
                    click:function(){
                        location.href = "https://www.google.com/"
                    }
                },
                ModalButton:{
                    text: "Events",
                    click:function(){
                    $('#exampleModal').modal('toggle');

                    }
                }
            },
            dateClick:function(info){
                $('#txtDate').val(info.dateStr);
                $('#exampleModal').modal();
                console.log(info);
                calendar.addEvent({title:"Evento", date:info.dateStr })
            },
            eventClick: function(info){

                console.log(info);
                console.log(info.event.title);
                console.log(info.event.start);
                console.log(info.event.end);
                console.log(info.textColor);
                console.log(info.backgroundColor);
                console.log(info.event.extendedProps.descripcion);

                $('#txtID').val(info.event.id)
                $('#txtTitle').val(info.event.title)

                $('#txtDate').val(info.event.start)
                $('#txtHour').val(info.event.start)

                $('#txtColor').val(info.event.backgroundColor)
                $('#txtDescription').val(info.event.extendedProps.descripcion)
                $('#exampleModal').modal();
            },
            events:"{{ url('/eventos/show') }}"

        });


        calendar.render();

        $('#btnAdd').click(function(){
            objEvent=captionDatosGUI("POST");

            SendInfo ('', objEvent);
        });

        function captionDatosGUI(method){

            newEvent={
                id:$('#txtID').val(),
                title:$('#txtTitle').val(),
                description:$('#txtDescription').val(),
                color:$('#txtColor').val(),
                textColor:'#FFFFF',
                start:$('#txtDate').val()+" "+$('#txtHour').val(),
                end:$('#txtDate').val()+" "+$('#txtHour').val(),
                '_token':$("meta[name='csrf-token']").attr("content"),
                '_method':method

            }
            return(newEvent);
        }
        function SendInfo (action, objEvent){
            $.ajax(
                {
                   type:"POST",
                   url: "{{ url('/eventos') }}"+action,
                   data:objEvent,
                   success:function(msg){console.log(msg);},
                   error:function(){alert("There are an error");}
                }
            );
        }
      });

    </script>
@endsection
@section('content')

<div class="row">
      <div class="col"></div>
      <div class="col-9"><div id="calendar"></div></div>
      <div class="col"></div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Event data</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          ID:
          <input type="text" name="txtID" id="txtID">
          <br/>
          DATE:
          <input type="text" name="txtDate" id="txtDate">
          <br/>
          Title:
          <input type="text" name="txtTitle" id="txtTitle">
          <br/>
          Hour:
          <input type="text" name="txtHour" id="txtHour">
          <br/>
          Description:
          <textarea name="txtDescription" id="txtDescription" cols="30" rows="10"></textarea>
          <br/>
          Color:
          <input type="color" name="txtColor" id="txtColor">
          <br/>
        </div>
        <div class="modal-footer">

          <button id="btnAdd" class="btn btn-success">Add</button>
          <button id="btnModify" class="btn btn-success">Modify</button>
          <button id="btnDelete" class="btn btn-danger">Delete</button>
          <button id="btnCancel" class="btn btn-secondary">Cancel</button>

       </div>
      </div>
    </div>
  </div>

@endsection
