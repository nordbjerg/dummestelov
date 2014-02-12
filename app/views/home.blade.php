@extends('templates.master')

@section('content')
	<table class="table">
		<thead>
			<tr>
				<th style="width: 20px">
					#
				</th>
				<th>
					Paragraf
				</th>
				<th>
					Stemmer
				</th>
				<th>
					Ministerium
				</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$max = 1200000;

			function nice($n) {
			    $s = array("TD", "M");
			    $out = "";
			    while ($n >= 1000 && count($s) > 0) {
			        $n = $n / 1000.0;
			        $out = array_shift($s);
			    }
			    return round($n, max(0, 3 - strlen((int)$n))).$out;
			}

			for($i = 1; $i <= 10; $i++) {
				?>
				<tr>
					<td>
						<?php echo $i; ?>
					</td>
					<td>
						Straffeloven, §1
					</td>
					<td>
						<?php echo nice($max - (100302 * $i)) ?>
					</td>
					<td>
						SFL
					</td>
				</tr>
				<?php
			}
			?>
		</tbody>
	</table>
	
	<div style="text-align: center">
		<ul class="pagination">
			<li><a href="#">&laquo;</a></li>
			<li><a href="#">1</a></li>
			<li><a href="#">2</a></li>
			<li><a href="#">3</a></li>
			<li><a href="#">4</a></li>
			<li><a href="#">5</a></li>
			<li><a href="#">1</a></li>
			<li><a href="#">2</a></li>
			<li><a href="#">3</a></li>
			<li><a href="#">4</a></li>
			<li><a href="#">5</a></li>
			<li><a href="#">&raquo;</a></li>
		</ul>
	</div>
@stop