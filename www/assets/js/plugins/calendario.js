$(function() {

	var cal = $( '#calendar' ).calendario( {
			onDayClick : function( $el, $contentEl, dateProperties ) {
				if(dateProperties["month"] < 10) dateProperties["month"] ="0"+dateProperties["month"];
				if(dateProperties["day"] < 10) dateProperties["day"] ="0"+dateProperties["day"];

				var gotodate = "";
				gotodate += dateProperties["year"];
				gotodate += dateProperties["month"];
				gotodate += dateProperties["day"];
				
				document.location.href=g5_url+"/ship/schedule.php?ymd="+gotodate;
			},
			caldata : codropsEvents
		} ),
	$month = $( '#custom-month' ).html( cal.getMonthName() ),
	$year = $( '#custom-year' ).html( cal.getYear() );

	$( '#custom-next' ).on( 'click', function() {
		//alert(cal.getYear()+" "+cal.getNextMonth()); 

		var y = cal.getYear();
		var m = cal.getMonth();
		if(m<10) m="0"+m;
		var m_oMonth= new Date(y, m, 0)
		m_oMonth.setDate(1);


		m_oMonth.setMonth(m_oMonth.getMonth() + 1);

		var yearGet = m_oMonth.getFullYear(); //년을 구한다
		var monthGet = m_oMonth.getMonth()+1; //월을 구한다.
		if(monthGet<10) monthGet="0"+monthGet;

		//alert(yearGet+" "+monthGet); 

		$.ajax({ 
			type: "GET",
			url: g5_url+"/ship/ajax_jsdata.php",
			data: "cy="+yearGet+"&cm="+monthGet, 
			beforeSend: function(){
				//loadstart();
			},
			success: function(msg){ 
				var msgarray = $.parseJSON(msg);

				cal.gotoNextMonth( updateMonthYear );
				cal.setData(  msgarray  );
			},
			complete: function(){
				//loadend();
			}
		});

	} );
	$( '#custom-prev' ).on( 'click', function() {

		var y = cal.getYear();
		var m = cal.getMonth();
		if(m<10) m="0"+m;
		var m_oMonth= new Date(y, m, 0)
		m_oMonth.setDate(1);

		m_oMonth.setMonth(m_oMonth.getMonth() - 1);

		var yearGet = m_oMonth.getFullYear(); //년을 구한다
		var monthGet = m_oMonth.getMonth()+1; //월을 구한다.
		if(monthGet<10) monthGet="0"+monthGet;


		$.ajax({ 
			type: "GET",
			url: g5_url+"/ship/ajax_jsdata.php",
			data: "cy="+yearGet+"&cm="+monthGet, 
			beforeSend: function(){
				//loadstart();
			},
			success: function(msg){ 
				var msgarray = $.parseJSON(msg);

				cal.gotoPreviousMonth( updateMonthYear );
				cal.setData(  msgarray  );
			},
			complete: function(){
				//loadend();
			}
		});

	} );
	$( '#custom-current' ).on( 'click', function() {


		var yearGet = cal.getYear();
		var monthGet = cal.getMonth();
		if(monthGet<10) monthGet="0"+monthGet;

		$.ajax({ 
			type: "GET",
			url: g5_url+"/ship/ajax_jsdata.php",
			data: "cy="+yearGet+"&cm="+monthGet, 
			beforeSend: function(){
				//loadstart();
			},
			success: function(msg){ 
				var msgarray = $.parseJSON(msg);

				cal.gotoNow( updateMonthYear );
				cal.setData(  msgarray  );
			},
			complete: function(){
				//loadend();
			}
		});
	} );

	function updateMonthYear() {				
		$month.html( cal.getMonthName() );
		$year.html( cal.getYear() );
	}

	// you can also add more data later on. As an example:
	/*
	someElement.on( 'click', function() {
		
		cal.setData( {
			'03-01-2013' : '<a href="#">testing</a>',
			'03-10-2013' : '<a href="#">testing</a>',
			'03-12-2013' : '<a href="#">testing</a>'
		} );
		// goes to a specific month/year
		cal.goto( 3, 2013, updateMonthYear );

	} );
	*/

});
