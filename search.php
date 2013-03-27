<?php include('nav.inc.php'); ?>
<!DOCTYPE html>
<html>
	<head lang="en">
		<title>Check Course Prerequisites</title>
        <!-- Boostrap/JQuery Includes -->
        <link href="css/bootstrap-journal.min.css" rel="stylesheet" media="screen">
        <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js' type='text/javascript'></script>
        <script src='js/bootstrap.min.js' type='text/javascript'></script>

        <style type="text/css">
            body {
                padding-top: 80px;
                padding-bottom: 40px;
            }
            .sidebar-nav {
                padding: 9px 0;
            }
            .table th, .table td {
              text-align: center;
              vertical-align: top;
            }
            .table td {
              padding-top: 10px;
            }
        </style>
<!-- <script language="javascript" type="text/javascript" src="../js/space.js"></script> -->
<script language="javascript" type="text/javascript" src="http://philogb.github.com/jit/static/v20/Jit/jit-yc.js"></script>

<script language="javascript" type="text/javascript">

var labelType, useGradients, nativeTextSupport, animate;

(function() {
  var ua = navigator.userAgent,
      iStuff = ua.match(/iPhone/i) || ua.match(/iPad/i),
      typeOfCanvas = typeof HTMLCanvasElement,
      nativeCanvasSupport = (typeOfCanvas == 'object' || typeOfCanvas == 'function'),
      textSupport = nativeCanvasSupport 
        && (typeof document.createElement('canvas').getContext('2d').fillText == 'function');
  //I'm setting this based on the fact that ExCanvas provides text support for IE
  //and that as of today iPhone/iPad current text support is lame
  labelType = (!nativeCanvasSupport || (textSupport && !iStuff))? 'Native' : 'HTML';
  nativeTextSupport = labelType == 'Native';
  useGradients = nativeCanvasSupport;
  animate = !(iStuff || !nativeCanvasSupport);
})();

var Log = {
  elem: false,
  write: function(text){
    if (!this.elem) 
      this.elem = document.getElementById('log');
    this.elem.innerHTML = text;
    this.elem.style.left = (500 - this.elem.offsetWidth / 2) + 'px';
  }
};


function init(){
<?php
echo 'var json = ';
$mysqli = new mysqli("localhost", "hardshell", "d0ntgue55m3", "hardshell");
function makeTree($course, $mysql) {
global $mysqli;
$stmt = $mysqli->prepare("SELECT name, prereqs FROM course_info WHERE name = ?");
$stmt->bind_param("s", $course);
$stmt->execute();
$stmt->bind_result($name,$prereqs);
$stmt->store_result();
while( $stmt->fetch() ) {
  echo '{';
  echo 'id: "'.$name.'", ';
  echo 'name: "'.$name.'", ';
  echo 'data: {}, ';
  echo 'children: [';
  $prqs = explode(", ", $prereqs);
  foreach ($prqs as $prr) {
    if( $prr == $name ) {
      continue;
    }
    if( strlen($prr) > 4 ) {
    makeTree($prr, $mysqli); 
    }

  }
  /* echo '{ id: "test", name: "test", data: {}, children: [] }'; */
  echo ']}';
}
$stmt->close();
}
echo ';';
makeTree($_POST['goal'], $mysqli);
?>
    //end
    //init Spacetree
    //Create a new ST instance
    var st = new $jit.ST({
        //id of viz container element
        injectInto: 'infovis',
        //set duration for the animation
        duration: 800,
        //set animation transition type
        transition: $jit.Trans.Quart.easeInOut,
        //set distance between node and its children
        levelDistance: 50,
        //enable panning
        Navigation: {
          enable:true,
          panning:true
        },
        //set node and edge styles
        //set overridable=true for styling individual
        //nodes or edges
        Node: {
            height: 20,
            width: 60,
            type: 'rectangle',
            color: '#aaa',
            overridable: true
        },
        
        Edge: {
            type: 'bezier',
            overridable: true
        },
        
        onBeforeCompute: function(node){
            Log.write("loading " + node.name);
        },
        
        onAfterCompute: function(){
            Log.write("done");
        },
        
        //This method is called on DOM label creation.
        //Use this method to add event handlers and styles to
        //your node.
        onCreateLabel: function(label, node){
            label.id = node.id;            
            label.innerHTML = node.name;
            label.onclick = function(){
            	if(normal.checked) {
            	  st.onClick(node.id);
            	} else {
                st.setRoot(node.id, 'animate');
            	}
            };
            //set label styles
            var style = label.style;
            style.width = 60 + 'px';
            style.height = 17 + 'px';            
            style.cursor = 'pointer';
            style.color = '#333';
            style.fontSize = '0.8em';
            style.textAlign= 'center';
            style.paddingTop = '3px';
        },
        
        //This method is called right before plotting
        //a node. It's useful for changing an individual node
        //style properties before plotting it.
        //The data properties prefixed with a dollar
        //sign will override the global node style properties.
        onBeforePlotNode: function(node){
            //add some color to the nodes in the path between the
            //root node and the selected node.
            if (node.selected) {
                node.data.$color = "#ff7";
            }
            else {
                delete node.data.$color;
                //if the node belongs to the last plotted level
                if(!node.anySubnode("exist")) {
                    //count children number
                    var count = 0;
                    node.eachSubnode(function(n) { count++; });
                    //assign a node color based on
                    //how many children it has
                    node.data.$color = ['#aaa', '#baa', '#caa', '#daa', '#eaa', '#faa'][count];                    
                }
            }
        },
        
        //This method is called right before plotting
        //an edge. It's useful for changing an individual edge
        //style properties before plotting it.
        //Edge data proprties prefixed with a dollar sign will
        //override the Edge global style properties.
        onBeforePlotLine: function(adj){
            if (adj.nodeFrom.selected && adj.nodeTo.selected) {
                adj.data.$color = "#eed";
                adj.data.$lineWidth = 3;
            }
            else {
                delete adj.data.$color;
                delete adj.data.$lineWidth;
            }
        }
    });
    //load json data
    st.loadJSON(json);
    //compute node positions and layout
    st.compute();
    //optional: make a translation of the tree
    st.geom.translate(new $jit.Complex(-200, 0), "current");
    //emulate a click on the root node.
    st.onClick(st.root);
    //end
    //Add event handlers to switch spacetree orientation.
    var top = $jit.id('r-top'), 
        left = $jit.id('r-left'), 
        bottom = $jit.id('r-bottom'), 
        right = $jit.id('r-right'),
        normal = $jit.id('s-normal');
        
    
    function changeHandler() {
        if(this.checked) {
            top.disabled = bottom.disabled = right.disabled = left.disabled = true;
            st.switchPosition(this.value, "animate", {
                onComplete: function(){
                    top.disabled = bottom.disabled = right.disabled = left.disabled = false;
                }
            });
        }
    };
    
    top.onchange = left.onchange = bottom.onchange = right.onchange = changeHandler;
    //end
};


</script>
	</head>	

    <body <?php if(isset($_POST['goal'])) { echo 'onload="init();"'; } ?> >

    <?php
      printNavbar("goals");
    ?>
    <div class='container-fluid'>

        <!-- START: main page -->
        <div class='row-fluid'>
            <?php printNavlist("goals"); ?>
            <div class='offset3 span4'>
              <!-- need to style table so it isn't so huge....only need like max 5 chars in each input box -->
              <form action='' method='POST'>
              <table class='table table-bordered table-hover'>
                <thead><tr><th style='text-align: center;'>Course Code</th></tr></thead>
                <tbody><tr><td><input type='text' name='goal' placeholder='CMSC132' /></td></tr></tbody>
              </table>  
              </form>
<br /><br />
<?php
if( isset($_POST['goal']) && preg_match("/\w{4}\d{3}\w?/", $_POST['goal']) ) {
  $mysqli = new mysqli("localhost", "hardshell", "d0ntgue55m3", "hardshell");
  if( $mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
  }

  $safe = 0;
  $arr = array();

?>
<table class='table table-bordered table-condensed table-hover'>
  <thead>
    <tr>
      <th style='text-align: center;'>Course Code</th>
      <th style='text-align: center;'>Credits</th>
      <th style='text-align: center;'>Prerequisites</th>
      <th style='text-align: center;'>Corequisites</th>
    </tr>
  </thead>
  <tbody>
<?php

  function getPre($ccode,$mysqli) {
  global $safe, $arr;
  $arr[] = $ccode;
  if( $safe >= 10 ) {
     return;
  }
  $safe++;
  $stmt = $mysqli->prepare("SELECT name, credits, prereqs, coreqs, description FROM course_info WHERE name = ?");
  $param = $ccode;
  $stmt->bind_param('s', $param);
  $stmt->execute();
  $stmt->bind_result($name,$credits,$prereqs,$coreqs,$desc);

    while( $stmt->fetch() ) {
      echo "<tr>";
      echo "<td><b>";
      echo "<a href='#' id='".$name."' class='btn btn-link' data-toggle='popover' data-trigger='hover' data-placement='left' data-content='".$desc."' title='".$name."'>".$name."</a>";
      echo "<script>$(function () { $('#".$name."').popover(); }); </script>";
      echo "</b></td><td>".$credits." credits</td>";
      if( strlen($prereqs) > 1 ) {
        echo "<td>".$prereqs."</td>";
      } else {
        echo "<td></td>";
      }
      if( strlen($coreqs) > 1 ) {
        echo "<td>".$coreqs."</td>";
      } else {
        echo "<td></td>";
      }
      echo "</tr>";
  }
  $prqs = explode( ", ", $prereqs );
  foreach ($prqs as $course) {
    if( $course == $ccode ) {
      continue;
    }
    if( in_array( $course, $arr ) ) {
      continue;
    }
    getPre($course,$mysqli);
  }
  }

  getPre( $_POST['goal'],$mysqli );

?>
</tbody>
</table>
<br /><br /><br /><br /><br />

<script language="javascript" type="text/javascript">
//init();
</script>
<?php
} elseif( isset($_POST['goal']) ) {
  echo '<b>Please enter a valid course code.</b>'; 
}
?>
<div id="center-container">
<div style="width:300px;height:300px;" id="infovis"></div>
</div>
<div style="visibility:hidden;" id="log"></div>

          </div>
        </div>
        <!-- END: main page -->

        <hr />

        <div class='footer'>
            <p>&copy; (insert creative team name here), 2013</p>
        </div>
    </div>

    </body>
</html>
