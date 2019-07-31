<?
//////////////////////////
// Author: Kevin Carter
// Date:   May 16 2019
//////////////////////////
?>

<?
include("codestart.php");

if(isset($_GET['uid'])){
  $pagetitle="User Availability ";
  $breadcrumb="Home > User > $pagetitle";
}else{
  $pagetitle="Myself - Availability ";
  $breadcrumb="Home > Myself > Availability";
  $uid=$user_id;
}

include("pagestart.php");

if(isset($_GET['uid'])){
  include("user_menu.php");
}else{
  include("self_menu.php");
}

print "<div class=\"pagetitle\">".$pagetitle."</div><br>";
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<link href='../fullcalendar-4.2.0/packages/core/main.min.css' rel='stylesheet' />
<link href='../fullcalendar-4.2.0/packages/daygrid/main.min.css' rel='stylesheet' />
<link href='../fullcalendar-4.2.0/packages/timegrid/main.min.css' rel='stylesheet' />
<script src='../fullcalendar-4.2.0/packages/core/main.min.js'></script>
<script src='../fullcalendar-4.2.0/packages/interaction/main.min.js'></script>
<script src='../fullcalendar-4.2.0/packages/daygrid/main.min.js'></script>
<script src='../fullcalendar-4.2.0/packages/timegrid/main.min.js'></script>


<script>


document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      plugins: [ 'interaction', 'dayGrid', 'timeGrid' ],
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      defaultDate: moment(Date.now()).format("Y-MM-DD HH:mm:ss"),
      events: 'user_available_load.php',
      navLinks: true, // can click day/week names to navigate views
      selectable: true,
      selectMirror: true,
      eventClick:function(info)
      {
        var event = info.event;
        if(confirm("Confirm delete?"))
        {
          var id = event.id;
          $.ajax({
          url:"user_available_delete.php",
          type:"POST",
          data:{id:id},
          success:function()
          {
            calendar.refetchEvents();
          }
          })
        }
      },
      eventResize:function(info)
      {
        var event = info.event;
        var start = moment(arg.start).format("Y-MM-DD HH:mm:ss");
        var end = moment(arg.end).format("Y-MM-DD HH:mm:ss");
        var title = event.title;
        var id = event.id;
        $.ajax({
          url:"user_available_update.php",
          type:"POST",
          data:{title:title, start:start, end:end, id:id},
          success:function(){
            calendar.refetchEvents();
          }
        })
      },

      eventDrop:function(info)
      {
        var event = info.event;
        var start = moment(arg.start).format("Y-MM-DD HH:mm:ss");
        var end = moment(arg.end).format("Y-MM-DD HH:mm:ss");
        var title = event.title;
        var id = event.id;
        $.ajax({
          url:"user_available_update.php",
          type:"POST",
          data:{title:title, start:start, end:end, id:id},
          success:function()
          {
            calendar.refetchEvents();
          }
        });
      },
      select: function(arg) {
        //var title = prompt('Event Title:');
        var title = 'Appointments';
        if (title) {
          var start = moment(arg.start).format("Y-MM-DD HH:mm:ss");
          var end = moment(arg.end).format("Y-MM-DD HH:mm:ss");
         
          $.ajax({
          url:"user_available_insert.php",
          type:"POST",
          data:{title:title, start:start, end:end},
          success:function()
          {
            calendar.refetchEvents();
          }
          })
        }
        calendar.unselect()
      },
      editable: true,
    });

    calendar.render();
  });
</script>

<style>
  #calendar {
    max-width: 1200px;
    margin: 0 auto;
    position: absolute;
	left: 10px;
    padding: 10px;
  }
</style>

</head>
<body>

  <div id='calendar'></div>

</body>
</html>
