<?php
//Creates variable to access database
$mysqli = new mysqli("localhost", "hardshell", "d0ntgue55m3", "hardshell");
$safe = 0;
$arr = array();
//Makes a tree based on the database and course number provided
function makeTree($code, $mysqli) {
global $arr, $safe;
$arr[] = $code;
//Prevents infinite looping
if( $safe >= 10 ) {
  return;
}
$safe++;
$stmt = $mysqli->prepare("SELECT name, prereqs FROM course_info WHERE name = ?");
$stmt->bind_param('s', $code);
$stmt->execute();
$stmt->bind_result($name, $prereqs);
$stmt->store_result();
// use php json encode?
/*
while( $stmt->fetch() ) {
  echo "{ id: 'node".$name."', name: '".$name."', data: {}, children: [";
  $prqs = explode(", ", $prereqs);
  foreach($prqs as $pr) {
    if( $name == $pr ) { continue; }
    if( in_array($pr, $arr) ) { continue; }
    if( strlen($pr) > 4 ) {
      makeTree($pr, $mysqli);
    }
  }
  echo "] } ";
}
 */
//Takes all prereqs and puts them into an array that will be used by the tree
while( $stmt->fetch() ) {
  $child = array();
  $prqs = explode(", ", $prereqs);
  foreach($prqs as $pr) {
    if( $name == $pr ) { continue; }
    if( in_array($pr, $arr) ) { continue; }
    if( strlen($pr) > 4 ) {
      $out = makeTree($pr, $mysqli);
      if( count($out) > 2 ) {
        $child[] = $out;
      }
    }
  }
  return array(
    'id' => 'node'.$name,
    'name' => $name,
    'children' => $child);
}
}
?>
//code used to make actually form the tree, involves formatting
function init() {
  //our data
  var json = <?php echo json_encode(makeTree($_POST['goal'], $mysqli)); echo ";";?>
  //

  //var json = { id: 'ALLCAPSNAME0', name: '132', data: {}, children: [{ id: '131', name: '131', data: {}, children: [] }] };


  var st = new $jit.ST({
    injectInto: 'treediv',
    type: '2D',
    orientation: 'top',
    transition: $jit.Trans.Quart.easeInOut,
    Node: {
      height: 40,
      width: 120,
      type: 'rectangle',
      color: '#aaa',
      overridable: true
    },
    Edge: {
      type: 'arrow',
      lineWidth: 3,
      overridable: true
    },
    onCreateLabel: function(label, node){
            label.id = node.id;            
            label.innerHTML = node.name;
            label.onclick = function(){
              st.onClick(node.id);
            };
            //set label styles
            var style = label.style;
            style.width = 110 + 'px';
            style.height = 40 + 'px';            
            style.cursor = 'pointer';
            style.color = '#333';
            style.fontSize = '1.25em';
            style.textAlign= 'center';
            style.paddingTop = '10px';
    }, 
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
    onBeforePlotLine: function(adj){
            if (adj.nodeFrom.selected && adj.nodeTo.selected) {
                adj.data.$color = "#eed";
                adj.data.$lineWidth = 3;
            }
            else {
                delete adj.data.$color;
                delete adj.data.$lineWidth;
            }
    },
    Navigation: {
      enable: true,
      panning: true
    }
  });

  st.loadJSON(json);

  st.compute();

  st.geom.translate(new $jit.Complex(500, 0), "current");

  st.onClick(st.root);
}
