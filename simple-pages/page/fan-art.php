<?php
$offset = isset($_GET['offset']) ? $_GET['offset'] : 0;
$result = gdao_get_fanart($offset);
$i=0;
?>
<div id="fancarousel">
	<a class="next"></a>
	<a class="prev"></a>
	<ul>

		<?php 
		foreach ($result['response']['docs'] as $index => $values)
			echo gdao_get_fanart_image($values);
		?>
		
	</ul>
</div>

<div id="alphalist">
	<a href="fan-art?letter=A">[A]</a>&nbsp; 
	<a href="fan-art?letter=B">[B]</a>&nbsp; 
	<a href="fan-art?letter=C">[C]</a>&nbsp;
	<a href="fan-art?letter=D">[D]</a>&nbsp; 
	<a href="fan-art?letter=E">[E]</a>&nbsp; 
	<a href="fan-art?letter=F">[F]</a>&nbsp; 
	<a href="fan-art?letter=G">[G]</a>&nbsp; 
	<a href="fan-art?letter=H">[H]</a>&nbsp; 
	<a href="fan-art?letter=I">[I]</a>&nbsp; 
	<a href="fan-art?letter=J">[J]</a>&nbsp; 
	<a href="fan-art?letter=K">[K]</a>&nbsp; 
	<a href="fan-art?letter=L">[L]</a>&nbsp; 
	<a href="fan-art?letter=M">[M]</a>&nbsp; 
	<a href="fan-art?letter=N">[N]</a>&nbsp; 
	<a href="fan-art?letter=O">[O]</a>&nbsp; 
	<a href="fan-art?letter=P">[P]</a>&nbsp; 
	<a href="fan-art?letter=Q">[Q]</a>&nbsp; 
	<a href="fan-art?letter=R">[R]</a>&nbsp; 
	<a href="fan-art?letter=S">[S]</a>&nbsp; 
	<a href="fan-art?letter=T">[T]</a>&nbsp; 
	<a href="fan-art?letter=U">[U]</a>&nbsp; 
	<a href="fan-art?letter=V">[V]</a>&nbsp; 
	<a href="fan-art?letter=W">[W]</a>&nbsp;
	<a href="fan-art?letter=X">[X]</a>&nbsp; 
	<a href="fan-art?letter=Y">[Y]</a>&nbsp; 
	<a href="fan-art?letter=Z">[Z]</a>&nbsp; 
	<a href="fan-art">[ALL]</a>
</div>
