<?php

error_reporting(E_ALL);

echo "<table id='tf' style='border: solid 1px black; border-collapse:collapse; text-align:center;'>";
echo "<tr><th style='width:150px;border:1px solid black;'>Id</th><th style='width:150px;border:1px solid black;'>Firstname</th><th style='width:150px;border:1px solid black;'>Lastname</th></tr>";
 
class TableRows extends RecursiveIteratorIterator {
    function __construct($it) { 
        parent::__construct($it, self::LEAVES_ONLY); 
    }
 
    function current() {
        return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
    }
 
    function beginChildren() { 
        echo "<tr>"; 
    } 
 
    function endChildren() { 
        echo "</tr>" . "\n";
    } 
} 

$servername = "127.0.0.1";
$username = "root";
$password = "*******";
$dbname = "test";
 
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
   // echo "连接成功"; 
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT id, name, password FROM user';
    $stmt = $conn->prepare($sql); 
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 

    // var_dump($stmt->fetchAll());
    foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) { 
        echo $v;
    }
}
catch(PDOException $e)
{
    echo $e->getMessage();
}

?>

<style type="text/css">
	.toast {
		position: absolute;
		top:20%;
		left:50%;

		transform: translate(-50%,-50%);
		border-radius: 3px;
		transition: all .3s linear;
		opacity: 1;
	}
	.toast.dismiss{
		opacity: 0;
	}
</style>

<script type="text/javascript">

function toast(name) {
	var body = document.querySelector('body');

	var toast = document.querySelector('.toast');
	if (toast) {
		body.removeChild(toast);
	}

	var div = document.createElement('div');
	div.className = 'toast';
	div.style = 'color:#fff; padding:15px; background:#000; font-size:13px';
	div.innerText = name;
	body.appendChild(div);

	setTimeout(function(){
		div.classList.add('dismiss');
	}, 1000);

}

window.onload = function() {
	var tf = document.querySelector('#tf');
	var tr = tf.querySelectorAll('tr');

	for(let i = 0; i < tr.length; i++) {
		if (i == 0) {
			continue;
		}
		tr[i].onclick = function() {
			const name = this.querySelectorAll('td')[1].innerText;
			//alert(name)
			//alert(i);
			toast(name);
		}
	}
	
}

</script>
?>
