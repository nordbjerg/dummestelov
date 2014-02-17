@extends('templates.master')

@section('content')
	<table class="table">
		<thead>
			<tr>
				<th style="width: 35px">
					#
				</th>
				<th style="width: 35px">
					Stemmer
				</th>
				<th>
					Paragraf
				</th>
				<th style="width: 37px">
					Ministerium
				</th>
			</tr>
		</thead>
		<tbody>
			<?php
			// TODO: Bladeify
			// TODO: Refactor
			$i = 0;
			$limit = 15;
			$sections = Section::popular()->paginate($limit);
			foreach($sections as $section) {
				?>
				<tr>
					<td>
						<?php echo ++$i + $limit * (Input::get('page', 1) - 1); ?>
					</td>
					<td>
						<?php echo $section->votes; ?>
					</td>
					<td>
						<?php echo "{$section->law->name}, §{$section->number}"; ?>
					</td>
					<td style="text-align: center">
						<?php echo $section->law->ministry; ?>
					</td>
				</tr>
				<?php
			}
			?>
		</tbody>
	</table>
	
	<div style="text-align: center">
		<?php echo $sections->links(); ?>
	</div>
@stop