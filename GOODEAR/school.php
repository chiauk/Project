<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html"; charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="css/search.css">
		<link rel="Shortcut Icon" type="image/x-icon" href="img/GERlogo.png" />
		<script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCb1nd7i3lNXGUx5v9-7kKrjbOLXYKeWu0&signed_in=true&callback=initMap" async defer></script>
		<script type="text/javascript">
		//讀取xml檔
		function loadXMLFile(file){

		      var xmlDoc;

		      if (window.ActiveXObject){
		         xmlDoc=new ActiveXObject("Microsoft.XMLDOM");
		         xmlDoc.async = false;
		         xmlDoc.load(file);
		         return xmlDoc;
		      } else if (document.implementation && document.implementation.createDocument){
		         var xmlInfo = new XMLHttpRequest();  
		         xmlInfo.open("GET", file, false);
		         xmlInfo.send(null); 
		         xmlDoc = xmlInfo.responseXML;
		         return xmlDoc;
		      }else{
		         alert("您的瀏覽器不支援Javascript!! ");
		      }
		}

		var districtName="高雄市";
		var reliType="all";
		var yourDistrict="NA";
		var yourAddress="NA";
		var yourReligion="all";

		//地圖顯示被選取地區
		function getView(d){
		console.log(d);
		districtName=d;
		yourDistrict="NA";
		yourAddress="NA";
		yourReligion="all";
		initMap();
		}

		function distance(lat1,lon1,lat2,lon2) {
 			var R = 6371; // km (change this constant to get miles)
 			var dLat = (lat2-lat1) * Math.PI / 180;
 			var dLon = (lon2-lon1) * Math.PI / 180;
 			var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
 			 Math.cos(lat1 * Math.PI / 180 ) * Math.cos(lat2 * Math.PI / 180 ) *
 			 Math.sin(dLon/2) * Math.sin(dLon/2);
 			var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
 			var d = R * c;
 			/*if (d>1) return Math.round(d)+"km";
			 else if (d<=1) return Math.round(d*1000)+"m";*/
			 return d;
		}

		var bNames = new Array();
		var bDistrict = new Array();
		var bAddress = new Array();
		var bReli = new Array();
		var ripLen;

		function initMap() {
		  var myLatLng = "";

		  var map = new google.maps.Map(document.getElementById('map'), {
		    zoom: 13,
		    center: myLatLng
		  });

		  var infowindow = null;

		 /* window.onload=function() { */
		     var xmlFile="xml/school.xml";
		     var xmlData=loadXMLFile(xmlFile);
		     var ripLen=xmlData.getElementsByTagName("Col1").length;


		      /*----------------district---------------*/

		      var Dxml=loadXMLFile("https://maps.googleapis.com/maps/api/geocode/xml?address="+districtName+"&key=AIzaSyCb1nd7i3lNXGUx5v9-7kKrjbOLXYKeWu0");
		      var center1=Dxml.getElementsByTagName("lat")[0].firstChild.nodeValue;
		      var center2=Dxml.getElementsByTagName("lng")[0].firstChild.nodeValue;

		      var myLatLng={lat: parseFloat(center1), lng: parseFloat(center2)};
		      var map = new google.maps.Map(document.getElementById('map'), {
		      zoom: 13,
		      center: myLatLng
		      });
		      var contentString=new Array();
		      var contentStr="";

		      infowindow = new google.maps.InfoWindow({
		      content: "holding..."
		      });

		      //--------------------------------------

		      var markers=new Array();
		      var olocate1="";
		      var olocate2="";
		      var Txml=0;
		      var urlocate1="";
		      var urlocate2="";
		      var Pxml=0;
		      var marker=0;

		      
		      if (yourDistrict !== "NA" && yourAddress !== "NA") {
		      		Pxml=loadXMLFile("https://maps.googleapis.com/maps/api/geocode/xml?address="+yourDistrict+yourAddress+"&key=AIzaSyCb1nd7i3lNXGUx5v9-7kKrjbOLXYKeWu0");
		      		urlocate1=Pxml.getElementsByTagName("lat")[0].firstChild.nodeValue;
		        	urlocate2=Pxml.getElementsByTagName("lng")[0].firstChild.nodeValue;
		        	var d=0;
		        	var tmpd=0;
		        	var getlocate1 = 0;
		   		   	var getlocate2 = 0;
		        	var getdistrict="";
		     	 	var getaddress="";
		    	  	var getreligion="";
		    	  	var gettel="";
		    	  	var getname="";

		      		for (var i=0 ; i<ripLen ; i++) {
				      	/*--------check_district--------*/
					        bDistrict[i] = xmlData.getElementsByTagName("Col1")[i].firstChild.nodeValue;
					        if (bDistrict[i] !== yourDistrict) {
					          continue;
					        }

					        /*--------check_reliType--------*/
					        if (yourReligion !== "all") {
					          bReli[i] = xmlData.getElementsByTagName("Col5")[i].firstChild.nodeValue;
					          if (bReli[i] !== yourReligion) {
					            continue;
					          }
					        }

					        bAddress[i] = xmlData.getElementsByTagName("Col3")[i].firstChild.nodeValue;
					        Txml=loadXMLFile("https://maps.googleapis.com/maps/api/geocode/xml?address="+bDistrict[i]+bAddress[i]+"&key=AIzaSyCb1nd7i3lNXGUx5v9-7kKrjbOLXYKeWu0");

		        
					        olocate1=Txml.getElementsByTagName("lat")[0].firstChild.nodeValue;
					        olocate2=Txml.getElementsByTagName("lng")[0].firstChild.nodeValue;
					        console.log("1: "+olocate1+" 2:"+olocate2);

					        tmpd=distance(urlocate1,olocate1,urlocate2,olocate2);
					        if (d <= tmpd) {
					        	d=tmpd;
					        	getlocate1=olocate1;
		        				getlocate2=olocate2;
		        				getdistrict=bDistrict[i];
		        				getaddress=bAddress[i];
		        				gettel=xmlData.getElementsByTagName("Col4")[i].firstChild.nodeValue;
		        				getreligion=xmlData.getElementsByTagName("Col5")[i].firstChild.nodeValue;
		        				getname=xmlData.getElementsByTagName("Col2")[i].firstChild.nodeValue;
					        }

					      }
					       contentStr='<div id="content">'+
					      '<div id="siteNotice">'+
					      '</div>'+
					      '<h1 id="firstHeading" class="firstHeading">'+getname+'</h1>'+
					      '<div id="bodyContent">'+
					      '<p>區域：'+getdistrict+'</p>'+
					      '<p>地址：'+getaddress+'</p>'+
					      '<p>電話：'+gettel+'</p>'+
					      '<p>營業項目：'+getreligion+'</p>'+
					      '</div>'+
					      '</div>';

					        var image = 'css/images/school_icon.png';
					        marker=new google.maps.Marker({
					        position: {lat: parseFloat(getlocate1), lng: parseFloat(getlocate2)},
					        map: map,
					        title: getname,
					        icon: image,
					        html: contentStr
					        });

					        map.setCenter(marker.getPosition());

					        google.maps.event.addListener(marker, 'click', function () {
					        // where I have added .html to the marker object.
					        infowindow.setContent(this.html);
					        infowindow.open(map, this);
					        });

					        var directionsService = new google.maps.DirectionsService;
  							var directionsDisplay = new google.maps.DirectionsRenderer;

  							directionsDisplay.setMap(map);

  							directionsService.route({
 							   origin: {lat: parseFloat(urlocate1), lng: parseFloat(urlocate2)},
 							   destination: {lat: parseFloat(getlocate1), lng: parseFloat(getlocate2)},
							    travelMode: google.maps.TravelMode.DRIVING
 								 }, function(response, status) {
  							  if (status === google.maps.DirectionsStatus.OK) {
  							    directionsDisplay.setDirections(response);
  							  } else {
  							   window.alert('Directions request failed due to ' + status);
  							  }
							  });



		      	}else{

		      for (var i=0 ; i<ripLen ; i++) {

	      	/*--------check_district--------*/
		        bDistrict[i] = xmlData.getElementsByTagName("Col1")[i].firstChild.nodeValue;
		        if (bDistrict[i] !== districtName) {
		          continue;
		        }

		        /*--------check_reliType--------*/
		        if (reliType !== "all") {
		          bReli[i] = xmlData.getElementsByTagName("Col5")[i].firstChild.nodeValue;
		          if (bReli[i] !== reliType) {
		            continue;
		          }
		        }

		        bAddress[i] = xmlData.getElementsByTagName("Col3")[i].firstChild.nodeValue;
		        //bNames[i] = xmlData.getElementsByTagName("Name")[i].firstChild.nodeValue;

		        Lxml=loadXMLFile("https://maps.googleapis.com/maps/api/geocode/xml?address="+bDistrict[i]+bAddress[i]+"&key=AIzaSyCb1nd7i3lNXGUx5v9-7kKrjbOLXYKeWu0");
		        
		        locate1=Lxml.getElementsByTagName("lat")[0].firstChild.nodeValue;
		        locate2=Lxml.getElementsByTagName("lng")[0].firstChild.nodeValue;
	    
		        contentString[i]='<div id="content">'+
		      '<div id="siteNotice">'+
		      '</div>'+
		      "<a href='http://"+xmlData.getElementsByTagName("Col5")[i].firstChild.nodeValue+"' style='font-family: 微軟正黑體; font-weight: bold; color:black;'>"+
		      '<h1 id="firstHeading" class="firstHeading">'+xmlData.getElementsByTagName("Col2")[i].firstChild.nodeValue+
		      "</a></br>"+'</h1>'+
		      "<div id='bodyContent' style='font-family: 微軟正黑體;'>"+
		      '<p>區域：'+xmlData.getElementsByTagName("Col1")[i].firstChild.nodeValue+'</p>'+
		      '<p>地址：'+xmlData.getElementsByTagName("Col3")[i].firstChild.nodeValue+'</p>'+
		      '<p>電話：'+xmlData.getElementsByTagName("Col4")[i].firstChild.nodeValue+'</p>'+
		      '</div>'+
		      '</div>';

		        var image = 'css/images/school_icon.png';
		        markers[i]=new google.maps.Marker({
		        position: {lat: parseFloat(locate1), lng: parseFloat(locate2)},
		        map: map,
		        title: xmlData.getElementsByTagName("Col2")[i].firstChild.nodeValue,
		        icon: image,
		        html: contentString[i]
		        });

		        var marker = markers[i]
		        google.maps.event.addListener(marker, 'click', function () {
		        // where I have added .html to the marker object.
		        infowindow.setContent(this.html);
		        infowindow.open(map, this);
		        });
		      }
		    }

		}
/*-------------------------------------------forEnd-------------------------------------------*/		

    	</script>
		<title>GoodEaR 動手找幫助</title>
	</head>
	<body>
		<div class="wrapper">
			<div class="header">
				<a href="index.php">
					<img src="images/logo.png" alt="">
				</a>
			</div>
			<div class="content">
				<a href="factory.php">
					<div class="grave">
						<img src="css/images/factory2.png" alt="">
					</div>
				</a>
				<a href="medical.php">
					<div class="grave">
						<img src="css/images/medical2.png" alt="">
					</div>
				</a>
				<a href="school.php">
					<div class="bone">
						<img src="css/images/school2.png" alt="">
					</div>
				</a>
				<a href="welfare.php">
					<div class="grave">
						<img src="css/images/welfare2.png" alt="">
					</div>
				</a>
				<a href="grants.php">
					<div class="grave">
						<img src="css/images/grants.png" alt="">
					</div>
				</a>
				<div class="clear"></div>
				<div class="main-content">
					<div class="select-options">
						<img src="css/images/all_view.png">
						<img src="css/images/all_view2.png">
						<select id="destrict" onchange="getView(this.value)">
							<option value="" selected="selected">請選擇</option>
						    <option value="基隆市">基隆市</option><option value="臺北市	">臺北市</option>
						    <option value="新北市">新北市</option><option value="桃園市">桃園市</option>
						    <option value="新竹縣">新竹縣</option><option value="新竹市">新竹市</option>
						    <option value="苗栗縣">苗栗縣</option><option value="臺中市">臺中市</option>
						    <option value="彰化縣">彰化縣</option><option value="南投縣">南投縣</option>
						    <option value="雲林縣">雲林縣</option><option value="嘉義縣">嘉義縣</option>
						    <option value="嘉義市">嘉義市</option><option value="臺南市">臺南市</option>
						    <option value="高雄市">高雄市</option><option value="屏東縣">屏東縣</option>
						    <option value="台東縣">台東縣</option><option value="花蓮縣">花蓮縣</option>
						    <option value="宜蘭縣">宜蘭縣</option>
    					</select>
							
						<div class="clear"></div>
					</div>
					<div id="map"></div>
				</div>
				<footer>
					&#169;GoodEaR 動手找幫助 2017<br/>
				</footer>
			</div>
		</div>
        <div class="back" style="float: right;">
            <a href="learn_class.php"><img src="img/backlearn.png" alt="" width="150" class="button"></a> 
        </div>
		<div class="fixlogout">
            <a href="logout.php"><img src="img/logout.png" width="200px" ></img></a>
        </div>
	</body>
</html>
