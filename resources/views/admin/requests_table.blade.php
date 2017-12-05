<table class="table" id="requests">
    <thead>
	<tr class="table-header">
	    <th>Панель</th>
	    <th>Пользователь</th>
	    <th>Данные</th>
	    <th>Файл трактовки</th>
	    <th>Дата добавления</th>
	</tr>
    </thead>
    <tbody>
	@foreach($aSeries as $series)
	<tr>
	    <td><a href="/panel/{{$aPanels[$series->panel_id]->id}}">{{$aPanels[$series->panel_id]->name}}</a></td>
	    <td><a href="/admin/users/profile/{{$aUsers[$series->user_id]->id}}">{{$aUsers[$series->user_id]->name}}</a></td>
	    <td>
		@if ($series->data_file)
		    <a href="/files/data/{{$series->id}}">Файл с данными</a>
		@else
		    Добавлены вручную
		@endif
	    </td>
	    <td>
		@if ($series->interpretation_file)
		    <a href="/files/interpretation/{{$series->id}}"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
		    (<a href="#" class="add-interpretation-file" data-series-id="{{$series->id}}">заменить</a>)
		@else
		    <a href="#" class="add-interpretation-file" data-series-id="{{$series->id}}">Добавить</a>
		@endif
	    </td>
	    <td>{{$series->date}}</td>
	</tr>
	@endforeach
    </tbody>
</table>

