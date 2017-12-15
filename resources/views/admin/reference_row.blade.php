<tr id="ref_row_{{$index}}">
    <td>
	<select name="sex_{{$index}}" >
	    <option value="0" @if (isset($oMRef) && $oMRef->sex == 0) selected @endif>Любой</option>
	    <option value="1" @if (isset($oMRef) && $oMRef->sex == 1) selected @endif>Мужской</option>
	    <option value="2" @if (isset($oMRef) && $oMRef->sex == 2) selected @endif>Женский</option>
	</select>
    </td>
    <td>
	<select name="age_{{$index}}" class="select-age" data-index="{{$index}}">
	    <option value="0">Любой</option>
	    <option value="1" @if (isset($oMRef) && ($oMRef->age_min || $oMRef->age_max)) selected @endif >Задать</option>
	</select>
	
	<div id="select_age_div_{{$index}}" @if (!isset($oMRef) || (!$oMRef->age_min && !$oMRef->age_max))style="display:none;" @endif>
	<div class="row">
	    <div class="col-sm-4">Минимальный:</div> <div  class="col-sm-2"><input name="age_min_{{$index}}" size="5" type="number" @if (isset($oMRef) && $oMRef->age_min) value="{{$oMRef->age_min}}" @endif ></input></div>
	</div>
	<div class="row">
	    <div class="col-sm-4">Максимальный:</div><div class="col-sm-2"> <input name="age_max_{{$index}}" size="5" type="number" @if (isset($oMRef) && $oMRef->age_max) value="{{$oMRef->age_max}}" @endif ></input></div>
	</div>
	</div>
    </td>
    <td>
        <input name="ref_min_{{$index}}" size="10" type="number" step="any" required @if (isset($oMRef) && $oMRef->ref_min) value="{{$oMRef->ref_min}}" @endif ></input>
    </td>
    <td>
        <input name="ref_max_{{$index}}" size="10" type="number" step="any" required @if (isset($oMRef) && $oMRef->ref_max) value="{{$oMRef->ref_max}}" @endif ></input>
    </td>
    <td>
        <a href="#" class="remove_ref_marker" data-marker-index="{{$index}}" title="Удалить референсе"><span class="glyphicon glyphicon-remove"></span></a>
    </td>
</tr>

