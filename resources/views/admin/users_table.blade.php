<table class="table" id="users">
    <thead>
	<tr class="table-header">
	    <th>ФИО</th>
	    <th>E-Mail</th>
	    <th>Сем. положение</th>
	    <th>Возраст</th>
	    <th>Пол</th>
	    <th>Кол-во анализов</th>
	    <th>Регистрация</th>
	</tr>
    </thead>
    <tbody>
	@foreach($aUsers as $user)
	<tr>
	    <td><a href="/admin/users/profile/{{$user->id}}"><img src="{{$user->getAvatarLink()}}" class="img-circle" width="40" height="40" /> 
		{{$user->name}}</a>
	    </td>
	    <td>{{$user->email}}</td>
	    <td>{{$user->getMaritalStatus()}}</td>
	    <td>{{$user->getAges()}}</td>
	    <td>
		@if ($user->gender == 0)
		    Мужской
		@else
		    Женский
		@endif
	    </td>
	    <td>
		{{count($user->getMarkers())}}
	    </td>
	    <td>
		{{$user->created_at}}
	    </td>
	</tr>
	@endforeach
    </tbody>
</table>


