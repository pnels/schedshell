function init() {
  //our data
  var json = 
<?php
$mysqli = new mysqli("localhost", "hardshell", "d0ntgue55m3", "hardshell");
function makeTree($code, $mysqli) {
$stmt = $mysqli->prepare("SELECT name, prereqs FROM course_info WHERE name = ?");
$stmt->bind_param('s', $course);
$stmt->execute();
$stmt->bind_result($name, $prereqs);
$stmt->store_result();
while( $stmt->fetch() ) {
  echo "{ id: '".$name."', name: '".$name."', data: {}, children: [";
  $prqs = explode(", ", $prereqs);
  foreach($prqs as $pr) {
    if( $name == $pr ) { continue; }
    if( strlen($pr) > 4 ) {
      makeTree($pr, $mysqli);
    }
  }
  echo "] }";
}
}

echo ";";

makeTree($_POST['goal'], $mysqli);

/*echo "{ id: 'node01', name: 'node01', data: {}, children: [\n";
echo "\t{ id: 'node02', name: 'node02', data: {}, children: [] },\n";
echo "\t{ id: 'node03', name: 'node03', data: {}, children: [\n";
echo "\t\t{ id: 'node04', name: 'node04', data: {}, children: [\n";
echo "\t\t\t{ id: 'node05', name: 'node05', data: {}, children: [] }\n";
echo "\t\t] },\n";
echo "\t\t{ id: 'node06', name: 'node06', data: {}, children: [] }\n";
echo "\t] }\n";
echo "] };";
*/
?>

  var st = new $jit.ST({
    injectInto: 'treediv',
    type: '2D',
    orientation: 'top',
    transition: $jit.Trans.Quart.easeInOut,
    Node: {
      height: 40,
      width: 150,
      type: 'rectangle',
      color: '#aaa',
      overridable: true
    },
    Edge: {
      type: 'bezier',
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
            style.width = 150 + 'px';
            style.height = 40 + 'px';            
            style.cursor = 'pointer';
            style.color = '#333';
            style.fontSize = '2em';
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

  st.geom.translate(new $jit.Complex(0, 500), "current");

  st.onClick(st.root);
}
