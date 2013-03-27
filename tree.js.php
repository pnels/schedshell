function init(){
  var json = 
<?php
/* function makeTree($course, $mysqli) {
$stmt = $mysqli->prepate("SELECT name, prereqs FROM course_info WHERE name = ?");
$param = $course;
$stmt->bind_param('s', $param);
$stmt->execute();
$stmt->bind_result($name,$prereqs);
while( $stmt->fetch() ) {
  echo '{';
  echo 'id: "'.$name.'",';
  echo 'name: "'.$name.'",';
  echo 'data: {},';
  echo 'children: [';
  $prqs = explode(", ", $prereqs);
  foreach ($prqs as $prr) {
    if( $prr == $name ) {
      continue;
    }
    makeTree($prr, $mysqli); 
  }
  echo ']}';
}
makeTree($_POST['goal'], $mysqli);
 */
?>
  ;
var tree = new $jit.ST({
  injectInto: 'infovis',
  duration: 600,
  transition: $jit.Trans.Quart.easeInOut,
  levelDistance: 50,
  Navigation: {
    enable: true,
    panning: true
  },
  Node: {
    height: 40,
    width: 120,
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
st.loadJSON(json);
st.compute();
st.onClick(st.root);
st.switchPosition(top);
}
