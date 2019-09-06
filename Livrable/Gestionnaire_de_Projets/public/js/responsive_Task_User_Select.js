
	var aTable = [],rTable = [];
	function contains(t, v){
		return (t.includes(v));
	}
	function addRow(v, isAdd, name, tcount){
		// console.log(v,isAdd,name,tcount);
		var ch = '<tr id="row'+((!isAdd)?'_OE_':'_CW_')+v+'">'+
			'<th scope="row" class="">'+name+'</th>'+
			'<th scope="row">'+
				'<span id="rangeRes" class="badge badge-success badge-pill float-center">'+tcount+
				'</span>'+
			'</th>'+
			'<td class="sm-1">'+
				'<input type="button"'+
				'onclick="'+((!isAdd)?'addTo':'removeFrom')+'('+v+', \''+name+'\', '+tcount+')" '+
				'value="'+((!isAdd)?'+':'X')+'" class="btn btn-'+((!isAdd)?"primary":"danger")+'" empid="'+v+'">'+
			'</td>'+
		'</tr>';
		return ch;
	}
	function addTo(v, name, tcount){
		if(!aTable.includes(v))
		{
			aTable.push(v);//avoid repited values
			$('#currentWorkers').append(addRow(v, 1, name, tcount+1));
			$('#row_OE_'+v).remove();
			if(rTable.includes(v)) rTable.splice(rTable.indexOf(v), 1); 
		}
		$('#addTable').val(aTable);
		console.log("a: "+aTable+", r: "+rTable);
	}
	function removeFrom(v, name, tcount){
		if(!rTable.includes(v))
		{
			rTable.push(v);//avoid repited values
			$('#otherEmployees').append(addRow(v, 0, name, tcount-1));
			$('#row_CW_'+v).remove();
			if(aTable.includes(v)) aTable.splice(aTable.indexOf(v), 1);
		}
		$('#removeTable').val(rTable);
		console.log("a: "+aTable+", r: "+rTable);
	}