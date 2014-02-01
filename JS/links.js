	cons=0;
	function show(cons){
		if(cons%2==0){
			showo(19,10);
		}
		else{
			showi(1300,10)
		}
	}
	function showo(widths,times){
		if(widths<=1340){
		var e=document.getElementById("LINKS");
		e.style.width=widths+"px";
		widths+=20;
		times+=1;
		setTimeout("showo("+widths+")",times);		
		}

	}
	function showi(widths,times){
		if(widths>=19){
		var e=document.getElementById("LINKS");
		e.style.width=widths+"px";
		widths-=20;
		times+=1;
		setTimeout("showi("+widths+")",times);		
		}

	}